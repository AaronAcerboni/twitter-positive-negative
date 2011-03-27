<?php

/*class responsible for converting data into something human readable*/

class Result{

	//TOOL LOGIC & DATA
	private $fetcher;
	
	private $negativeData;
	private $positiveData;
	private $searchTerm;
	
	//UTILITY
	public $resultError;
	
	// DATA RESULTS
	private $positivePercentage;
	private $negativePercentage;
	private $percentageType;
	
	/******************************/
	
	function __construct($fetcher){
		$this->fetcher = $fetcher;
	}
		
	public function getPercentages(){
		return array("positive" => $this->positivePercentage, "negative" => $this->negativePercentage);
	}
	public function getPercentageType(){
		return $this->percentageType;
	}
	
	public function setData($data){
		$this->negativeData = $data["negative"];
		$this->positiveData = $data["positive"];
		$this->searchTerm = $data["searched"];
	}

	public function parseData(){
		return $this->assessDataVolume();
	}
	
	/******************************/
	
	private function assessDataVolume(){
	
		//Tally
	
		$tempPos=0;
		$tempNeg=0;
		for($i=0; $i < count($this->negativeData["results"]); $i++){
			$tempNeg++;
		}
		for($i=0; $i < count($this->positiveData["results"]); $i++){
			$tempPos++;
		}
		
		
		//Check if tally has results
		
		if(($tempPos + $tempNeg) != 0){
		
			//Assess wether more results are needed			
			if($tempPos == 100 || $tempNeg == 100){
				
				//Tweet rate scenario START
				
				$this->percentageType = "tweetRate";
							
				//set beginning range
				$earliestPositive = $this->assessTime("early","p");
				$earliestNegative = $this->assessTime("early","n");
				
				//get an appropriate old range
				$this->setData( $this->fetcher->getData($this->getPageGuestimate()) );
				
				//set the appropriate old range
				$oldestPositive = $this->assessTime("old","p");
				$oldestNegative = $this->assessTime("old","n");
				
				/*Parameters for tweet rate scenario are fed in reverse because because the shortest time range represents
				the more popular search.*/
				$this->makePercentage(($earliestNegative-$oldestNegative),($earliestPositive-$oldestPositive));
				
			} else {
			
				$this->percentageType = "tally";
				$this->makePercentage($tempPos,$tempNeg);
				
			}
			
			return true; //true because data found
			
		} else {
			$this->resultError = "No data found";
			return false; // false because no data found
		}
	}
	
	
	//TWEET RATE SPECIFIC FUNCTIONS
	private function assessTime($age,$dataSet){ //returns a time in seconds (int)
		if($dataSet == "p"){
			if($age == "early"){
				return strtotime( $this->positiveData["results"][0]["created_at"] );
			} else if ($age == "old"){
				return strtotime( $this->positiveData["results"][count($this->positiveData["results"])-1]["created_at"] );
			} else {
				die("parameter age provided was not 'early' or 'old' @ Result.assessTime");
			}
		} else if ($dataSet = "n"){
			if($age == "early"){
				return strtotime( $this->negativeData["results"][0]["created_at"] );
			} else if ($age == "old"){
				return strtotime( $this->negativeData["results"][count($this->negativeData["results"])-1]["created_at"] );
			} else {
				die("parameter age provided was not 'early' or 'old' @ Result.assessTime");
			}			
		} else {
			die("parameter dataSet provided was not 'p' or 'n' @ Result.assessTime");
		}
	}
	
	private function getPageGuestimate(){		
		//Get an average time difference between tweets
		
		$earliestTime = strtotime($this->positiveData["results"][0]["created_at"]);
		$oldestTime = strtotime($this->positiveData["results"][99]["created_at"]);
		$tweetDifference = $oldestTime - $earliestTime;
		
		$chosenPage = 2;
		
		return $chosenPage;
	}
	
	//
	
	private function makePercentage($pos, $neg){
		$this->positivePercentage = round( ($pos / ($pos + $neg))*100 );
		$this->negativePercentage = round( 100 - $this->positivePercentage );
	}
}
?>