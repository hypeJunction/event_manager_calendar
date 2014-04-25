<?php

/**
 * Normalize dates when event objects are created or updated
 */
function event_manager_calendar_update_event_notation($event, $type, $entity) {

	if (!$entity instanceof Event) {
		return true;
	}

	event_manager_calendar_normalize_event_dates($entity);

	return true;
}
