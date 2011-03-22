<?php
include("Fetcher.php");
include("Result.php");

/*This routine may vary but the result object always needs the data from the fetcher on
construction. This can change if it will make a nicer interface.*/

	$fetcher = new Fetcher();
	
	$fetcher->setSearchTerm($_GET['q']);
	
	$result = new Result($fetcher->getData()) or die("no results found");
	
	$percentages = $result->getPercentages() . "%";
	$algorithmUsed = $result->getPercentageType();
	
	//Twitter positive negative use is over.
	
	echo "Positive : " . $percentages["positive"] . "<br/>";
	echo "Negative : " . $percentages["negative"] . "<br/>";
	echo "Algorithm : " . $algorithmUsed;
?>