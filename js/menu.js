function mainmenu(){
$("#dropmenu a").removeAttr('title');
$(" #dropmenu ul ").css({display: "none"}); // Opera Fix
$(" #dropmenu li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(400);
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
}

 
 
 $(document).ready(function(){					
	mainmenu();
});