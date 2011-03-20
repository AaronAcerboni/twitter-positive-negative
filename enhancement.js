$(document).ready(function(){
	
	/*Initialise listeners*/
	$("div.section form").submit(
		function(){
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
	
});