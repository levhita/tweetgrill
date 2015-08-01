$(document).ready(function(){

	$('#tweets .tweet').each(function(){
		var text = $(this).text();
		$(this).html(nl2br(twttr.txt.autoLink(twttr.txt.htmlEscape(text))));
		//$(this).html(twttr.txt.autoLink(twttr.txt.htmlEscape(text)));
	});
	
});

function nl2br (str) {
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
}