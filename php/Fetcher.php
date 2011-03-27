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
	
	public function getData(){
		$param = func_get_args();
		if($this->searchTermSet){
			switch(count($param)){
			
				case 0 ://get 1st page
					$pData = file_get_contents($this->apiInterface . "q=" . $this->searchTerm ."+%3A)"."&result_type=recent&rpp=100") or die("Fail at :) file_get_contents @ Fetcher.getData(0)");
					$nData = file_get_contents($this->apiInterface . "q=" . $this->searchTerm ."+%3A("."&result_type=recent&rpp=100") or die("Fail at :( file_get_contents @ Fetcher.getData(0)");
					//collate data
					$data = array("positive" => json_decode($pData, true), "negative" => json_decode($nData, true) , "searched" => $this->searchTerm);
					//return data
					return $data;
				break;
				
				case 1 ://get x page
					if(is_numeric($param[0])){
						$pData = file_get_contents($this->apiInterface . "q=" . $this->searchTerm ."+%3A)"."&result_type=recent&rpp=100&page=".$param[0]) or die("Fail at :) file_get_contents @ Fetcher.getData(1)");
						$nData = file_get_contents($this->apiInterface . "q=" . $this->searchTerm ."+%3A("."&result_type=recent&rpp=100&page=".$param[0]) or die("Fail at :( file_get_contents @ Fetcher.getData(1)");
						//collate data
						$data = array("positive" => json_decode($pData, true), "negative" => json_decode($nData, true) , "searched" => $this->searchTerm);
						//return data
						return $data;
					} else {
						die("Parameter specified was not a (page) number @ Fetcher.getData");
					}
				break;
				default : die("More than one parameter was specified @ Fetcher.getData()");
			}
		} else {
			die("Search term was never set.\n Use Fetcher.setSearchTerm() before Fetcher.getData().");
		}
	}

}
?>