function slideDown(url)
{
    $("div#panel").slideDown("slow");
    document.getElementById('toggle1').innerHTML='<a id="close1" style="display: block;" class="close1" href="javascript:slideUp(\''+url+'\');">Cerrar</a>';    
    document.getElementById('panel').innerHTML='<iframe src="'+url+'" style="width:100%;height:470px;border:none;padding:none;overflow:hidden;"></iframe>';
}
function slideUp(url)
{
    $("div#panel").slideUp("slow");
    document.getElementById('toggle1').innerHTML='<a id="open1" class="open1" href="javascript:slideDown(\''+url+'\');">Funcionarios</a>';
}
//$(document).ready(function() {
//	
//	// Expand Panel
//	$("#open1").click(function(){
//		$("div#panel").slideDown("slow");
//                document.getElementById('toggle1').innerHTML='<a id="close1" style="display: block;" class="close" href="#">Close Panel</a>';
//	});	
//	
//	// Collapse Panel
//	$("#close1").click(function(){
//		$("div#panel").slideUp("slow");	
//                document.getElementById('toggle1').innerHTML='<a id="open1" class="open1" href="#">Log In | Register</a>';
//                
//	});		
//	
//	// Switch buttons from "Log In | Register" to "Close Panel" on click
//			
//		
//});