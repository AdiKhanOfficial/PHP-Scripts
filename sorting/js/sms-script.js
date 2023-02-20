$("document").ready(function(){
	$("#navigator").mouseover(function(){
		menu = $("#menu-bar");
		menu.fadeToggle();
		$("#navigator").html('<span class="glyphicon glyphicon-menu-left"></span>');
		
	})
	
	
	$("#content").mouseover(function(){
		menu = $("#menu-bar");
			menu.fadeOut();
			$("#navigator").html('<span class="glyphicon glyphicon-menu-right"></span>');
	})
})
function collapse(id){
	$(".sub-menu").slideUp();
	if(document.getElementById("staff-sub").style.display != "block")
	$("#"+id).slideToggle();
	
}
		