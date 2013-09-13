<?php

error_reporting(E_ALL);

function __autoload($classname) {
    $filename = "./Services/". $classname .".php";
    include_once($filename);
}

require_once('./config.php');

try {
   $feeder = new CurlClient();
} catch (Exception $e) {
    die($e->getMessage() . PHP_EOL);
}

//$tournaments = simplexml_load_string($feeder->sendRequest($poker_feed_url));

$fileN = 'upcoming_tournaments.xml';
$tournaments = simplexml_load_file($fileN);


$conversion_rates = json_decode($feeder->sendRequest($currency_feed_url), TRUE);

$transformer = new Transformer($conversion_rates);

$validator = new TournamentValidator();

$output = array();
 
foreach($tournaments as $tournament) {
 	
 	if($validator->isValid($tournament)) {
 		
		 $transformer->setTournament($tournament);
 		 $transformer->convertCurrency('USD','GBP');
 		 $transformer->convertTime();

		 $output[] = $transformer->getTournament();
 	}
  
 }

 if (count($output)) {
	echo json_encode($output);	
}



