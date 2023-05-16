<?php
/**
 * Menus
 *
 * @package   MyAAC
 * @author    Slawkens <slawkens@gmail.com>
 * @copyright 2019 MyAAC
 * @link      https://my-aac.org
 */
defined('MYAAC') or die('Direct access not allowed!');
$title = 'Settings';

require_once SYSTEM . 'clients.conf.php';
if (empty($_GET['plugin'])) {
	error('Please select plugin from left Panel.');
	return;
}

$plugin = $_GET['plugin'];

if($plugin != 'core') {
	$pluginSettings = Plugins::getPluginSettings($plugin);
	if (!$pluginSettings) {
		error('This plugin does not exist or does not have settings defined.');
		return;
	}

	$settingsFilePath = BASE . $pluginSettings;
}
else {
	$settingsFilePath = SYSTEM . 'settings.php';
}

if (!file_exists($settingsFilePath)) {
	error("Plugin $plugin does not exist or does not have settings defined.");
	return;
}

$settingsFile = require $settingsFilePath;
if (!is_array($settingsFile)) {
	error("Cannot load settings file for plugin $plugin");
	return;
}

if (isset($_POST['save'])) {
	$db->query('DELETE FROM `' . TABLE_PREFIX . 'settings` WHERE `plugin_name` = ' . $db->quote($plugin) . ';');
	foreach ($_POST['settings'] as $key => $value) {
		try {
			$db->insert(TABLE_PREFIX . 'settings', ['plugin_name' => $plugin, 'key' => $key, 'value' => $value]);
		} catch (PDOException $error) {
			warning('Error while saving setting (' . $plugin . ' - ' . $key . '): ' . $error->getMessage());
		}
	}

	$cache = Cache::getInstance();
	if ($cache->enabled()) {
		$cache->delete('settings');
	}

	success('Saved at ' . date('H:i'));
}

$title = ($plugin == 'core' ? 'Settings' : 'Plugin Settings - ' . $plugin);

$settings = Settings::display($plugin, $settingsFile['settings']);

$twig->display('admin.settings.html.twig', [
	'settings' => $settings,
]);
