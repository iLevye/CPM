
$.fn.form_check = function(options) {
	var settings = $.extend( {
	    }, options);

	return this.each(function() {
		alert($(this).html());


	});
}