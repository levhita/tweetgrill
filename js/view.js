$(document).ready(function(){

	$('#contents .content').each(function(){
		var text = $(this).text();
		twttr.txt.autoLink("#hashtag @mention http://test.com");
		$(this).html(nl2br(twttr.txt.autoLink(twttr.txt.htmlEscape(text),{urlTarget:'_blank'})));
	});
	
});

function nl2br (str) {
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
}