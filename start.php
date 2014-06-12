<?php

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/events.php';
require_once __DIR__ . '/lib/hooks.php';

elgg_register_event_handler('init', 'system', 'event_manager_calendar_init');

elgg_register_event_handler('create', 'object', 'event_manager_calendar_update_event_notation');
elgg_register_event_handler('update', 'object', 'event_manager_calendar_update_event_notation');

function event_manager_calendar_init() {

	/**
	 * JS and CSS
	 */
	elgg_extend_view('css/elgg', 'event_manager/calendar/css');
	elgg_extend_view('js/elgg', 'event_manager/calendar/js');

	/**
	 * Actions
	 */
	elgg_register_action('event_manager/normalize', __DIR__ . '/actions/normalize.php', 'admin');

	/**
	 * Hooks
	 */
	elgg_register_plugin_hook_handler('route', 'events', 'event_manager_calendar_router');
	
	/**
	 * Views
	 */
	elgg_extend_view('page/elements/sidebar', 'event_manager/calendar/sidebar');
	elgg_extend_view('groups/tool_latest', 'event_manager/calendar/group_module');
	
	elgg_register_ajax_view('event_manager/calendar/widget/events');
	elgg_register_ajax_view('event_manager/calendar/selectable');

	/**
	 * Widgets
	 */
	elgg_register_widget_type('event_manager_calendar', elgg_echo('event_manager:calendar:widget'), elgg_echo('event_manager:calendar:widget:desc'));
}