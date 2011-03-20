<?php
include("Fetcher.php");
include("Result.php");

	$fetcher = new Fetcher();
	
	$fetcher->setSearchTerm($_GET['q']);
	
	$result = new Result($fetcher->getData()) or die("no results found");
	
	$percentages = $result->getPercentages();
	
	 // optional... $percentageType = $result->getPercentageType();
	
	//return $percentage or even $percentageType as needed
	echo "Positive : " . $percentages["positive"] . "<br/>";
	echo "Negative : " . $percentages["negative"] . "<br/>";
	echo "Algorithm : " . $result->getPercentageType();
?>