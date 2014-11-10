<?php

function event_manager_calendar_normalize_event_dates($entity) {

	$calendar_start = $entity->start_day + date('H', $entity->start_time) * 60 * 60 + date('i', $entity->start_time) * 60;
	$calendar_end = ($entity->end_ts) ? $entity->end_ts : $entity->calendar_start + 60 * 60;

	create_metadata($entity->guid, 'calendar_start', $calendar_start, '', $entity->owner_guid, $entity->access_id);
	create_metadata($entity->guid, 'calendar_end', $calendar_end, '', $entity->owner_guid, $entity->access_id);
}

function event_manager_calendar_get_day_start($date) {

	if (!is_int($date)) {
		$date = strtotime($date);
	}

	$d = (int) date('j', $date);
	$m = (int) date('n', $date);
	$y = (int) date('Y', $date);

	return mktime(0, 0, 1, $m, $d, $y);
}

function event_manager_calendar_get_day_end($date) {

	if (!is_int($date)) {
		$date = strtotime($date);
	}

	$d = (int) date('j', $date);
	$m = (int) date('n', $date);
	$y = (int) date('Y', $date);

	return mktime(23, 59, 59, $m, $d, $y);
}

function event_manager_calendar_constrain_by_date($date = null, $options = array()) {

	if (!$date) {
		$date = date('d-m-Y');
	}

	$start = event_manager_calendar_get_day_start($date);
	$end = event_manager_calendar_get_day_end($date);

	$dbprefix = elgg_get_config('dbprefix');
	/*
	add_metastring preprecated in elgg 1.9. Now use elgg_get_metastring_id
	*/
	$mdbtws_name_id = elgg_get_metastring_id('calendar_start');
	$mdbtwe_name_id = elgg_get_metastring_id('calendar_end');

	$options['joins'][] = "JOIN {$dbprefix}metadata mdbtws ON mdbtws.entity_guid = e.guid AND mdbtws.name_id = $mdbtws_name_id";
	$options['joins'][] = "JOIN {$dbprefix}metastrings mdbtwsv ON mdbtwsv.id = mdbtws.value_id";
	$options['joins'][] = "JOIN {$dbprefix}metadata mdbtwe ON mdbtwe.entity_guid = e.guid AND mdbtwe.name_id = $mdbtwe_name_id";
	$options['joins'][] = "JOIN {$dbprefix}metastrings mdbtwev ON mdbtwev.id = mdbtwe.value_id";
	$options['wheres'][] = "((mdbtwsv.string > $start AND mdbtwsv.string <= $end) OR (mdbtwev.string > $start AND mdbtwev.string <= $end) OR (mdbtwsv.string <= $start AND mdbtwev.string >= $end))";
	$options['order_by'] = "mdbtwsv.string ASC";

	return $options;
}

function event_manager_calendar_constrain_by_owner($owner = null, $options = array()) {

	if (!$owner) {
		return $options;
	}

	$dbprefix = elgg_get_config('dbprefix');

	if (elgg_instanceof($owner, 'user')) {
		$rels = event_manager_event_get_relationship_options();
		foreach ($rels as $rel) {
			$rels_in[] = "'$rel'";
		}
		$rels_in = implode(',', $rels_in);
		$options['joins'][] = "JOIN {$dbprefix}entity_relationships erpg ON e.guid = erpg.guid_one";
		$options['wheres'][] = "(e.owner_guid = $owner->guid OR (erpg.guid_two = $owner->guid AND erpg.relationship IN ($rels_in)))";
	} else if (elgg_instanceof($owner, 'group')) {
		$options['container_guids'] = $owner->guid;
	}

	return $options;
}

function event_manager_calendar_is_in_progress($entity) {
	$time = time();
	return ($entity->calendar_start <= $time && $entity->calendar_end >= $time);
}

function event_manager_calendar_is_finished($entity) {
	$time = time();
	return ((isset($entity->calendar_end) && $entity->calendar_end <= $time) || ($entity->calendar_start <= $time));
}
