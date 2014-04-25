<?php

$entity = elgg_extract('entity', $vars, false);

if (!$entity) {
	$entity = elgg_get_site_entity();
}

$format = elgg_extract('format', $vars, 'list');
$limit = elgg_extract('limit', $vars, 10);
$offset = elgg_extract('offset', $vars, 0);

$date = elgg_extract('date', $vars);
if (!$date) {
	$date = date('d-m-Y');
}

$options = array(
	'types' => 'object',
	'subtypes' => Event::SUBTYPE,
	'full_view' => false,
	'limit' => $limit,
	'offset' => $offset,
	'count' => true,
	'pagination' => false,
);

$options = event_manager_calendar_constrain_by_date($date, $options);

if ($entity) {
	$options = event_manager_calendar_constrain_by_owner($entity, $options);
}

$count = elgg_get_entities_from_metadata($options);

if ($count) {
	$options['count'] = false;
	$events = elgg_get_entities_from_metadata($options);

	echo elgg_view('event_manager/calendar/widget/list', array(
		'entities' => $events,
		'date' => $date,
	));
} else {
	echo '<span class="placeholder">' . elgg_echo('event_manager:calendar:day_empty', array($date)) . '</span>';
}

echo elgg_view('event_manager/calendar/widget/pager', array(
	'date' => $date,
	'count' => $count,
	'limit' => $limit,
	'offset' => $offset,
	'entity' => $entity,
));
