<?php
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
	
	public function getData(){
		if(searchTermSet){
			/*
			$positiveData = file_get_contents($apiInterface . "q=" . $searchTerm ."+%3A)"."&result_type=recent&rpp=100") or die("Fail at :) file_get_contents @ Fetcher.getData()");
			$negativeData = file_get_contents($apiInterface . "q=" . $searchTerm ."+%3A("."&result_type=recent&rpp=100") or die("Fail at :( file_get_contents @ Fetcher.getData()");
			*/
			$positiveData = file_get_contents("http://www.search.twitter.com/search.json?q=" . $searchTerm ."+%3A)"."&result_type=recent&rpp=100") or die("Fail at :) file_get_contents @ Fetcher.getData()");
			$negativeData = file_get_contents("http://www.search.twitter.com/search.json?q=" . $searchTerm ."+%3A("."&result_type=recent&rpp=100") or die("Fail at :( file_get_contents @ Fetcher.getData()");
		
			//collate data
			$data = array( "positive" => json_decode($positiveData, true), "negative" => json_decode($negativeData, true) , "searched" => $searchTerm);
			//return data
			return $data;
			
		} else {
			die("Search term was never set.\n Use setSearchTerm() before getData().");
		}
	}

}
?>



