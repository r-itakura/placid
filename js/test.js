$(function(){
	$("ul#mainNav li").hover(function(){
		$("> ul:not(:animated)" , this).animate({
			height : "toggle",
			opacity : "toggle"
		}, 500 );
	},
	function(){
		$("> ul" , this).fadeOut("slow");
	});
});