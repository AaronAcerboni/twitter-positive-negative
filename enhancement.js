$(document).ready(function(){
	
	/*Initialise listeners*/
	$("div.section form").submit(
		function(){
			showLoader();
			query();
			return false;
		}
	);
	
	/*Functions*/
	function query(){
		
		var v = $("form").serialize();
		
		$.get(
			"php/routine.php",
			v,
			function(data){
				parseData(data);
			}
			);
	}
	
	function parseData(data){
		$('#graph').html("<h1>Optimism</h1>"+data);
	}
	
	function showLoader(){
		$('#graph').html("<h1>Optimism</h1><p><img src='img/loader.gif' alt='getting results'/></p>");
	}
	
});