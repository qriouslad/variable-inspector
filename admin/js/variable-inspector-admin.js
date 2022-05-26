(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// Simple Accordion -- https://codepen.io/gecugamo/pen/xGLyXe

	$.fn.simpleAccordion = function() {

		this.on("click", ".accordion__control", function() {

				// Toggle the panel next to the item that was clicked
				$(this).toggleClass("accordion__control--active").next().slideToggle(250);

		});
	
		// Return jQuery object for method chaining
		return this;
	}

	$(document).ready( function() {

		// Append links to plugin's main page header

        var addReview = '<a href="https://wordpress.org/plugins/variable-inspector/#reviews" target="_blank" class="header-action"><span>&starf;</span> Review</a>';
        var giveFeedback = '<a href="https://wordpress.org/support/plugin/variable-inspector/" target="_blank" class="header-action">&#10010; Feedback</a>';
        var donate = '<a href="https://paypal.me/qriouslad" target="_blank" class="header-action">&#10084; Donate</a>';

        $(donate).prependTo('.vi .csf-header-right');
        $(giveFeedback).prependTo('.vi .csf-header-right');
        $(addReview).prependTo('.vi .csf-header-right');

        // Clear inspection results

		$('.clear-results').click( function( eventObject ) {

			eventObject.preventDefault();

			var button = $( this );

			$.ajax({
				url: ajaxurl,
				data: {
					'action':'vi_clear_results'
				},
				success:function(response) {

					response = JSON.parse(response)

					if ( response.success == true ) {

						$( '#inspection-results' ).remove();

					}

				},
				error:function(errorThrown) {
					console.log(errorThrown);
				}
			});

		});

		// Accordion init

		$(".accordion").simpleAccordion();

	});

})( jQuery );
