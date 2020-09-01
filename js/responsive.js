/*
	*	Original script by: Guilherme Manteigas
	*	Version 1.0
*/
function feedSize(){
	if ($(window).width() < 768) {
		document.getElementById("feed").style.width = "90%";
		document.getElementById("feed").style.fontSize = "50%;"; 
	}
	else if($(window).width() < 992){
	   	document.getElementById("feed").style.width = "60%";
		document.getElementsByClassName("feed").style.fontSize = "70%;";
	}
}