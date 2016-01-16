/*--------------------------------------------------

Claire and Joe
Main Scripts [main.js]

Copyright (c)
Joe Morrow <js@joemorrow.org>
5:08 PM 6/02/2014

--------------------------------------------------*/

// Allow a tweak for certain browsers, boo to worthless feature detection.
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
var isWebKit = 'WebkitAppearance' in document.documentElement.style;
$(function() {
	if (isSafari)
		$("html").addClass("safari");
	if (isWebKit)
		$("html").addClass("webkit");
});


// jQuery things go here
$(function() {

	// Prevent firing for empty links
	$("a.unlink, a[href='#']").click(function() {
		return false;
	});

	// Move the nav menu on the homepage
	$(".home section#news").after($("nav"));

	// Add Google Analytics events automatically to external links (from:  https://developers.google.com/analytics/devguides/collection/analyticsjs/events)
	$("a.external").click(function() {
		var theURL = $(this).attr("href");
		ga('send', 'event', 'outbound', 'click', theURL);
	});

	// RSVP Page functionality
	$("body.rsvp fieldset.hidden").hide().removeClass("hidden").find("input[required]").addClass("required").removeAttr("required");

	// Toggle RSVP fields based on response
	function rsvpChange(to) {
		if (to == "accept") {
			$("body.rsvp fieldset.accept").show();
			$("body.rsvp #comments label").html("Comments and dietary preferences");
			$("body.rsvp input.required").attr("required", true);
		} else {
			$("body.rsvp fieldset.accept").hide();
			$("body.rsvp #comments label").html("Comments");
			$("body.rsvp input.required").removeAttr("required");
		}
	}

	// Set the initial state
	rsvpChange($("body.rsvp input[name=attendance]:checked").val());

	// Then, change based on user input
	$("body.rsvp input[name=attendance]").change(function() {
		rsvpChange(this.value);
	});

});
