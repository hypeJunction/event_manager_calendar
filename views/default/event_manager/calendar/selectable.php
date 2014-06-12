<?php

$entity = elgg_extract('entity', $vars, elgg_get_site_entity());

$d = get_input('date');
$m = get_input('month');
$y = get_input('year');

$date = mktime(0, 0, 1, $m, $d, $y);

for ($i = -15; $i <= 15; $i++) {

	if ($i > 0) {
		$odate = strtotime("+$i days", $date);
	} else if ($i == 0) {
		$odate = $date;
	}

	$str = date('j-n-Y', $odate);

	$options = array(
		'types' => 'object',
		'subtypes' => Event::SUBTYPE,
		'count' => true,
	);

	$options = event_manager_calendar_constrain_by_date($str, $options);

	if ($entity) {
		$options = event_manager_calendar_constrain_by_owner($entity, $options);
	}

	$count = elgg_get_entities_from_metadata($options);

	if (!$count) {
		$output[$str] = array(
			0 => false, // not selectable
			1 => 'calendar-widget-no-event',
			2 => elgg_echo('event_manager:calendar:day_empty', array($str))
		);
	} else {
		$output[$str] = array(
			0 => true, // selectable
			1 => 'calendar-widget-has-event', // additional css classes
			2 => elgg_echo('event_manager:calendar:day_count', array($count, $str))
		);
	}
}

echo json_encode($output);
