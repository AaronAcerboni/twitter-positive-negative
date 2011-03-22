<?php
/*Class responsible for retrieving data*/

class Fetcher{

	// API INTERFACE CONFIGURATION
	private $apiInterface = "http://www.search.twitter.com/search.json?";
	private $searchTerm = "To be set by caller @ setSearchTerm";
	private $searchTermSet = false;	
	
	// DATA
	private $negativeData;
	private $positiveData;
	
	/******************************/
	
	public function setSearchTerm($search){
		$this->searchTerm = urlencode($search);
		$this->searchTermSet = true;
	}
	
	public function getData(){//FUTURE: specify page number as parameter for when Result must get a wider range of tweets
		if($this->searchTermSet){
		
			$pData = file_get_contents("http://www.search.twitter.com/search.json?q=" . $this->searchTerm ."+%3A)"."&result_type=recent&rpp=100") or die("Fail at :) file_get_contents @ Fetcher.getData()");
			$nData = file_get_contents("http://www.search.twitter.com/search.json?q=" . $this->searchTerm ."+%3A("."&result_type=recent&rpp=100") or die("Fail at :( file_get_contents @ Fetcher.getData()");
		
			//collate data
			$data = array( "positive" => json_decode($pData, true), "negative" => json_decode($nData, true) , "searched" => $this->searchTerm);
			//return data
			return $data;
			
		} else {
			die("Search term was never set.\n Use setSearchTerm() before getData().");
		}
	}

}
?>



