$(function () {
    $.fn.fancyzoom.defaultsOptions.imgDir='js/jq/fancyzoom/resources/';

    $("img").each(function () {
	$caption = $(this).attr("alt");
	if (!$(this).attr("title"))
	    $(this).attr("title", $caption);
	if ($(this).hasClass("no_zoom")) return(1);
	// http://flowplayer.org/tools/tooltip/index.html
	// $(this).tooltip({ position: "top center", tipClass: "jq_tooltip" });
	if ($(this).parent().get(0).tagName != "A")
	    $(this).wrap('<a href="' + $(this).attr("src") + '"></a>').fancyzoom();
   });
});

