<?php

if (!elgg_in_context('main') && !elgg_in_context('activity')) {
	return;
}

$vars['entity'] = elgg_get_site_entity();

$title = elgg_echo('event_manager:calendar:site');
$mod = elgg_view('event_manager/calendar/widget', $vars);

echo elgg_view_module('aside', $title, $mod);
