<?php

$entity = elgg_extract('entity', $vars);

$vars['entity'] = $entity;
$events = elgg_view('event_manager/calendar/widget/events', $vars);

$mod = <<<__HTML
<div class="calendar-widget" data-guid="$entity->guid">
	<div class="calendar-widget-picker elgg-ajax-loader"></div>
	<div class="calendar-widget-list">$events</div>
</div>
__HTML;

echo $mod;
