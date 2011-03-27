<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>tweetLike - discern optimism</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
<script type="text/javascript" src="enhancement.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style.css"/>
<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="styleIE.css"/>
<![endif]-->
</head>

<?php

include("php/Fetcher.php");
include("php/Result.php");

	if(isset($_GET["q"])){
		$fetcher = new Fetcher();	
		$fetcher->setSearchTerm($_GET['q']);
		
		$results = new Result($fetcher);
		
		$results->setData($fetcher->getData());
		
		$results->parseData() or die ($results->resultError);
		
		$percentages = $results->getPercentages();
	}	
?>

<body>
	<header>
		<div role="banner">
			<img alt="tweet like" src="img/tweetLike.jpg"/>beta
		</div>
	</header>
	<section>
			<div class="section">
				<ul>
					<li>[tweet-lahyk]</li>
					<li class="lexical">-noun</li>
				</ul>
				<ol>
					<li>A simple web analytic tool used for discerning general
						positive or negative concencus from twitter about a 
						chosen subject.
					</li>
				</ol>
			</div>
			<div class="section">
				<h1>Search</h1>
				<form action="/" method="GET">
					<input type="text" name="q" placeholder="Subject"/>
					<input type="submit" value="Query"/>
				</form>
				<p>Please use single word subjects for now.</p>
				<p>Refrain from including complex characters or text emoticons.</p>
				<p>If you have javascript disabled you will recieve no visual feedback to the processing.
				   Please just be patient, thanks.</p>
			</div>
			<div class="section">
				<h1>Popular searches</h1>
				<ul class="tags">
					<li class="positive">Simon</li>
					<li class="negative">Bananarama</li>
					<li class="negative">Water parks</li>
					<li class="positive">Sushi bars</li>
					<li class="positive">Simon</li>
					<li class="negative">Bananarama</li>
					<li class="negative">Water parks</li>
					<li	class="positive">Sushi bars</li>
				</ul>
			</div>
			<div class="section">			
			<h1>Your past searches</h1>
			<ul class="tags">
				<li class="positive">Sushi bars</li>
			</ul>
			</div>
			<div class="section">			
			<h1>Learn more</h1>
				<p>tweetLike is open-source so check it out on <a href="https://github.com/AaronAcerboni/twitter-positive-negative">github</a>.</p>
				<p><em>Anyone can get involved.</em></p>
				<p><a href="http://halfmelt.com">Aaron Acerboni @ halfmelt.com</a></p>
				<p><a href="http://twitter.com/AaronAcerboni">AaronAcerboni @ twitter.com</a></p>
			</div>
	</section>
	<section>
		<div class="section" id="graph">
			<h1>Optimism</h1>
			<!--graph-->
			<?php	
			if(isset($_GET["q"])){
				if(strlen($_GET["q"]) > 0){
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
				echo "<p>Make a search.</p>";
			}
			?>
		</div>
	</section>
</body>
</html>