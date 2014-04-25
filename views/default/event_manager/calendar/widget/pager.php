<?php

$entity = elgg_extract('entity', $vars);

$count = elgg_extract('count', $vars);
$limit = elgg_extract('limit', $vars);
$offset = elgg_extract('offset', $vars);

$date = elgg_extract('date', $vars);

echo '<div class="calendar-widget-pager">';

if ($count > $limit + $offset) {
	$next_offset = $limit + $offset;

	if ($offset + $limit >= $count) {
		$text = elgg_echo('event_manager:calendar:pager:remaining', array($count - $offset));
	} else {
		$text = elgg_echo('event_manager:calendar:pager:following', array($limit));
	}

	echo elgg_view('output/url', array(
		'text' => $text,
		'href' => 'ajax/view/event_manager/calendar/widget/events',
		'class' => 'calendar-widget-pager-more',
		'data-limit' => $limit,
		'data-offset' => $next_offset,
		'data-date' => $date,
		'data-guid' => $entity->guid,
	));
}

echo '<div class="calendar-widget-next-prev">';
echo elgg_view('output/url', array(
	'text' => elgg_echo('event_manager:calendar:pager:prev'),
	'href' => '#',
	'data-date' => date('d-m-Y', strtotime($date . ' -1 day')),
	'class' => 'calendar-widget-pager-prev',
));

echo elgg_view('output/url', array(
	'text' => elgg_echo('event_manager:calendar:pager:next'),
	'href' => '#',
	'data-date' => date('d-m-Y', strtotime($date . ' +1 day')),
	'class' => 'calendar-widget-pager-next',
));
echo '</div>';

echo '</div>';
