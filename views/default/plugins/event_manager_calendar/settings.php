<?php

$total_count = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => Event::SUBTYPE,
	'count' => true
		));

$updated_count = elgg_get_entities_from_metadata(array(
	'types' => 'object',
	'subtypes' => Event::SUBTYPE,
	'metadata_names' => 'calendar_start',
	'count' => true
		));

$count = $total_count - $updated_count;

if ($count) {

	echo '<div class="mam">';
	echo '<p>' . elgg_echo('event_manager:calendar:normalize_required', array($count)) . '</p>';
	echo elgg_view('output/url', array(
		'text' => elgg_echo('event_manager:calendar:normalize'),
		'href' => 'action/event_manager/normalize',
		'is_action' => true,
		'class' => 'elgg-button elgg-button-action',
	));
	echo '</div>';
}