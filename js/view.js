$(document).ready(function(){

	$('#tweets .tweet').each(function(){
		var text = $(this).text();
		$(this).html(twttr.txt.autoLink(twttr.txt.htmlEscape(text)));
	});
	
});