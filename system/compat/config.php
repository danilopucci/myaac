<?php

$deprecatedConfig = [
	'date_timezone',
	'genders',
	'template',
	'template_allow_change',
	'vocations_amount',
	'vocations',
	'client',
	'session_prefix',
	'friendly_urls',
	'backward_support',
	'charset',
	'meta_description',
	'meta_keywords',
	'footer',
	//'language',
	'visitors_counter',
	'visitors_counter_ttl',
	'views_counter',
	'outfit_images_url',
	'outfit_images_wrong_looktypes',
	'item_images_url',
	'account_country',
	'news_author',
	'news_limit',
	'news_ticker_limit',
	'news_date_format',
	'highscores_groups_hidden',
	'highscores_ids_hidden',
	'online_record',
	'online_vocations',
	'online_vocations_images',
	'online_skulls',
	'online_outfit',
	'online_afk',
	'team_display_outfit' => 'team_outfit',
	'team_display_status' => 'team_status',
	'team_display_world' => 'team_world',
	'team_display_lastlogin' => 'team_lastlogin',
	'multiworld',
	'forum',
	'signature_enabled',
	'signature_type',
	'signature_cache_time',
	'signature_browser_cache',
];

foreach ($deprecatedConfig as $key => $value) {
	config(
		[
			(is_string($key) ? $key : $value),
			setting('core.'.$value)
		]
	);

	//var_dump($settings['core.'.$value]['value']);
}
