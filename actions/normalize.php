<?php

set_time_limit(0);

$events = new ElggBatch('elgg_get_entities', array(
	'types' => 'object',
	'subtypes' => Event::SUBTYPE,
	'limit' => 0,
		));

$i = 0;
foreach ($events as $event) {
	if (!isset($event->calendar_start)) {
		event_manager_calendar_normalize_event_dates($event);
		$i++;
	}
}

system_message(elgg_echo('event_manager:calendar:normalize_success', array($i)));

forward(REFERER);
