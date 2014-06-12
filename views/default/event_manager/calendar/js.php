//<script>

	elgg.provide('elgg.events.calendar');

	/**
	 * Cache day properties
	 * @type object
	 */
	elgg.events.calendar.days = {};

	elgg.events.calendar.trottle = false;

	/**
	 * DOM ready
	 * @returns {void}
	 */
	elgg.events.calendar.init = function() {

		$('.calendar-widget-picker').removeClass('elgg-ajax-loader').datepicker({
			dateFormat: 'dd-mm-yy',
			firstDay: 1,
			beforeShowDay: function(dt) {
				var date = dt.getDate(),
						month = dt.getMonth() + 1,
						year = dt.getFullYear(),
						str = date + '-' + month + '-' + year;
				if (!elgg.events.calendar.days[str]) {
					elgg.events.calendar.getDayProperties($(this), dt);
					return [true];
				}
				return elgg.events.calendar.days[str];
			}
		}).live('change', function(e) {
			var $picker = $(this);
			elgg.ajax('ajax/view/event_manager/calendar/widget/events', {
				data: {
					date: $picker.val(),
					guid: $picker.closest('.calendar-widget').data('guid')
				},
				beforeSend: function() {
					$picker.next('.calendar-widget-list').html($('<div>').addClass('calendar-widget-loader'));
				},
				success: function(data) {
					$picker.next('.calendar-widget-list').html(data);
				}
			});
		});

		$('.calendar-widget-pager-more').live('click', function(e) {
			e.preventDefault();

			var $elem = $(this);
			var $pager = $elem.closest('.calendar-widget-pager');
			var $list = $pager.closest('.calendar-widget-list');

			elgg.ajax($elem.attr('href'), {
				data: $elem.data(),
				beforeSend: function() {
					$pager.replaceWith($('<div>').addClass('calendar-widget-loader'));
				},
				success: function(data) {
					$list.find('.calendar-widget-loader').remove();
					$list.append(data);
				}
			});
		});

		$('.calendar-widget-pager-next').live('click', function(e) {
			e.preventDefault();

			var $elem = $(this);
			var $widget = $(this).closest('.calendar-widget');
			$widget.find('.calendar-widget-picker').datepicker('setDate', $elem.data('date')).trigger('change');
		});

		$('.calendar-widget-pager-prev').live('click', function(e) {
			e.preventDefault();

			var $elem = $(this);
			var $widget = $(this).closest('.calendar-widget');
			$widget.find('.calendar-widget-picker').datepicker('setDate', $elem.data('date')).trigger('change');
		});
	};

	/**
	 * Load day properties (+/- 15days)
	 * @param {object} $picker UI Datepicker dom element
	 * @param {Date} dt
	 * @returns {void}
	 */
	elgg.events.calendar.getDayProperties = function($picker, dt) {

		if (elgg.events.calendar.throttle) {
			return;
		}
		
		elgg.ajax('ajax/view/event_manager/calendar/selectable', {
			beforeSend: function() {
				elgg.events.calendar.throttle = true;
				$picker.addClass('calendar-widget-loader');
			},
			data: {
				date: dt.getDate(),
				month: dt.getMonth() + 1,
				year: dt.getFullYear(),
				guid: $picker.closest('.calendar-widget').data('guid')
			},
			dataType: 'json',
			success: function(data) {
				$.extend(elgg.events.calendar.days, data);
				elgg.events.calendar.throttle = false;
				$picker.removeClass('calendar-widget-loader').datepicker('refresh');
			}
		});
	};

	elgg.register_hook_handler('init', 'system', elgg.events.calendar.init);

