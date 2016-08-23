/**
 * @package itstudy
 */

jQuery(document).ready(function($) {
	jQuery(function($) {
		jQuery('#sortable-table-itstudy tbody').sortable({
			axis: 'y',
			handle: '.column-order',
			placeholder: 'ui-state-highlight',
			forcePlaceholderSize: true,
			update: function(event, ui) {
				var theOrder = jQuery(this).sortable('toArray');
	
				var data = {
					action: 'itstudy_lesson_update_post_order',
					postType: jQuery(this).attr('data-post-type'),
					order: theOrder
				};
	
				jQuery.post(ajaxurl, data, function(response) {
					if(response) {
						jQuery(".wrap h2").after('<p class="itstudy-alert">' + response + '</p>');
					}
				});
			}
		}).disableSelection();
	
	});
});