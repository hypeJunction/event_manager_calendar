<?php if (false) : ?><style type="text/css"><?php endif; ?>

	.calendar-widget {
		font-size: 90%;
	}
	.calendar-widget-picker {
		padding: 3px;
		background: none;
		margin: 0 0 10px 0;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		border: 1px solid #e9e9e9;
		min-height: 50px;
	}

	.calendar-widget-picker .ui-datepicker {
		width: 100%;
		max-width: 100%;
	}
	.calendar-widget-picker .ui-widget-content {
		padding: 0;
		margin: 0;
		background: none;
		border: none;
	}

	.calendar-widget-picker .ui-datepicker .ui-datepicker-calendar {
		margin: 5px 0 0;
		width: 100%;
	}
	.calendar-widget-picker .ui-datepicker .ui-datepicker-calendar th,
	.calendar-widget-picker .ui-datepicker .ui-datepicker-calendar td {
		font-size: 12px;
		line-height: 16px;
		text-align: center;
		padding: 1px;
	}
	.calendar-widget-picker .ui-datepicker .ui-state-active {
		background: #000;
		color: #FFF;
		font-weight: bold;
		font-size: 110%;
	}
	.calendar-widget-loader {
		width: 100%;
		height: 16px;
		display: block;
		background: transparent url(<?php echo elgg_get_site_url() . 'mod/event_manager_calendar/graphics/ajax-loader.gif' ?>) no-repeat 50% 50%;
		margin: 10px;
	}

	.calendar-widget-event.calendar-widget-event-in-progress {
		font-weight: bold;
	}

	.calendar-widget-event.calendar-widget-event-finished * {
		color: #666;
	}
	.calendar-widget-pager-more, .calendar-widget-next-prev {
		margin: 10px;
		text-align: center;
		display: block;
	}
	.calendar-widget-pager-prev {
		width: 50%;
		display: inline-block;
		text-align: left;
	}
	.calendar-widget-pager-next {
		width: 50%;
		display: inline-block;
		text-align: right;
	}