<?php

$group = elgg_get_page_owner_entity();

if ($group->event_manager_enable == "no") {
	return;
}

$vars['entity'] = $group;
$content = elgg_view('event_manager/calendar/widget', $vars);

$all_link = elgg_view('output/url', array(
	'href' => "/events/event/list/" . $group->getGUID(),
	'text' => elgg_echo('link:view:all'),
));

$new_link = elgg_view('output/url', array(
	'href' => "/events/event/new/" . $group->getGUID(),
	'text' => elgg_echo('event_manager:menu:new_event'),
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('event_manager:calendar:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));

