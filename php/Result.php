<?php

/*class responsible for converting data into something human readable*/

class Result{

	// DATA
	private $negativeData;
	private $positiveData;
	private $searchTerm;
	
	// DATA RESULTS
	private $positivePercentage;
	private $negativePercentage;
	private $percentageType;
	
	/******************************/
	
	function __construct($data){
		$this->negativeData = $data["negative"];
		$this->positiveData = $data["positive"];
		$this->searchTerm = $data["searched"];
		return $this->assessDataVolume();
	}
	
	private function assessDataVolume(){
	
		//Tally
	
		$tempPos;
		$tempNeg;
		for($i=0; $i < count($negativeData["results"]); $i++){
			$tempNeg++;
		}
		for($i=0; $i < count($positiveData["results"]); $i++){
			$tempPos++;
		}
		
		
		//Check if tally has results
		
		if(($tempPos + $tempNeg) != 0){
		
			//Assess wether more results are needed			
			if($tempPos = 100 || $tempNeg = 100){
			
				$percentageType = "tweetRate";
				//tweetRate scenario
				//when asking for more pages reuse the Fetcher object passed in with class wide availability
				
			} else {
			
				$percentageType = "tally";
				makePercentage($tempPos,$tempNeg);
				
			}
			
			return true; //true because data found
			
		} else {
			return false; // false because no data found
		}
	}
	
	private function makePercentage($pos, $neg){
		$positivePercentage = round( ($pos / ($pos + $neg))*100 );
		$negativePercentage = round( 100 - $positivePercentage );
	}
	
	public function getPercentages(){
		return array("positive" => $positivePercentage, "negative" => $negativePercentage);
	}
	public function getPercentageType(){
		return $percentageType;
	}
}
?>