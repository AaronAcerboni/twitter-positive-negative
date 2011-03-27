<?php
include("Fetcher.php");
include("Result.php");

	if(isset($_GET["q"])){
		if(strlen($_GET["q"]) > 0){
			$fetcher = new Fetcher();	
			$fetcher->setSearchTerm($_GET['q']);
			
			$results = new Result($fetcher);
			
			$results->setData($fetcher->getData());
			
			$results->parseData() or die ($results->resultError);
			
			$percentages = $results->getPercentages();
			
			echo "<p>Positive : <span class='resultPositive'>" . $percentages["positive"] . "%</span></p>";
			echo "<p>Negative : <span class='resultNegative'>" . $percentages["negative"] . "%</span></p>";

			echo "<p>Derived from the ";
				if($results->getPercentageType() == "tally"){
					echo "tally algorithm.</p>";
				} else if ($results->getPercentageType() == "tweetRate"){
					echo "tweet rate algorithm.</p>";
				}
		} else {
			echo "<p>Your search parameter was or came up empty <span class='sadface'>:(</span></p>";
		}
	} else {
		echo "<p>Your search parameter was or came up empty <span class='sadface'>:(</span></p>";
	}
?>