//<script>

	elgg.provide('elgg.events.calendar');


	elgg.events.calendar.init = function() {
		$('.calendar-widget-picker').removeClass('elgg-ajax-loader').datepicker({
			dateFormat : 'dd-mm-yy',
			firstDay: 1
		}).live('change', function(e) {
			var $picker = $(this);
			elgg.ajax('ajax/view/event_manager/calendar/widget/events', {
				data : {
					date : $picker.val(),
					guid : $picker.closest('.calendar-widget').data('guid')
				},
				beforeSend : function() {
					$picker.next('.calendar-widget-list').html($('<div>').addClass('calendar-widget-loader'));
				},
				success : function(data) {
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
				data : $elem.data(),
				beforeSend : function() {
					$pager.replaceWith($('<div>').addClass('calendar-widget-loader'));
				},
				success : function(data) {
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

	elgg.register_hook_handler('init', 'system', elgg.events.calendar.init);

