<?php

$entities = elgg_extract('entities', $vars);
$date = elgg_extract('date', $vars, date('d-m-Y'));
$start = event_manager_calendar_get_day_start($date);
$end = event_manager_calendar_get_day_end($date);
$today_start = event_manager_calendar_get_day_start(date('d-m-Y'));
$today_end = event_manager_calendar_get_day_start(date('d-m-Y'));

if (is_array($entities)) {

	foreach ($entities as $entity) {

		$help = array();
		
		$status = 'future';
		$class = 'calendar-widget-event-future';
		if (event_manager_calendar_is_in_progress($entity)) {
			$status = 'in_progress';
			$class = 'calendar-widget-event-in-progress';
		} else if (event_manager_calendar_is_finished($entity)) {
			$status = 'finished';
			$class = 'calendar-widget-event-finished';
		}

		echo '<div class="calendar-widget-event ' . $class . ' clearfix">';
		echo '<div class="elgg-col elgg-col-1of4">';
		if ($entity->calendar_start < $today_start && $entity->calendar_end > $today_start) {
			$help[] = elgg_echo('event_manager:calendar:started', array(date('M d', $entity->calendar_start), date('H:i', $entity->calendar_start)));
		} 
		if ($entity->calendar_start >= $start && $entity->calendar_start <= $end) {
			echo date("H:i", $entity->calendar_start);
		} else {
			echo date("M d H:i", $entity->calendar_start);
		}

		echo '</div>';

		echo '<div class="elgg-col elgg-col-3of4">';
		echo elgg_view('output/url', array(
			'text' => $entity->title,
			'href' => $entity->getURL(),
			'target' => '_blank',
		));

		if ($entity->calendar_end < time()) {
			$help[] = elgg_echo('event_manager:calendar:ended', array(elgg_view_friendly_time($entity->calendar_end)));
		} else if ($entity->calendar_end <= $today_end) {
			$help[] = elgg_echo('event_manager:calendar:ends_today', array(date('H:i', $entity->calendar_end)));
		} else {
			$help[] = elgg_echo('event_manager:calendar:ends', array(date('M d', $entity->calendar_end), date('H:i', $entity->calendar_end)));
		}

	
		if (sizeof($help)) {
			echo '<div class="elgg-text-help">' . implode('<br />', $help) . '</div>';
		}
		
		echo '</div>';
		echo '</div>';
	}
}