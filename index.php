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
	// logowanie do pliku?
    die($e->getMessage() . PHP_EOL);
}

//wszystko ponizej powinno byc w try wyjatku
$tournamentsXML = simplexml_load_string($feeder->sendRequest($poker_feed_url));
//nazwy obiektow w liczbie pojedynczej
$PokerTournaments = new PokerTournaments($tournamentsXML);
$tournaments = $PokerTournaments->getFilteredTournaments($tournaments_filters);


//$currency_rates = simplexml_load_string($feeder->sendRequest($currency_feed_url));

var_dump(count($tournaments));

//Ja API widze tak: 

$url = 'xxxx';
$client = new CurlClient();

 $validator = new TournamentValidator();
 $tournaments = $client->send($url);
 
 $output = array();
 
 foreach($tournaments as $tournamentData) {
 	
		 //tutaj tworzymy nasz obiekt tournament w srodku moga bys smieci
		 $transformer = new Transformer($tournamentData);
 		 $tournament = $transformer->getTournament();
		 
 	if($validator->isValid($tournament) {
 		
		//tutaj wiemy juz ze to co jest w obiekcie jest ok np ze ma ta wartosc ktora musi byc wieksza od X  i ze ta wartosc jest wieksza od X
		// wiec mozemy go dalej przetworzyc
 		 $transformer-> convertCurrenc();
 		 $transformer-> convertTime();
 		 $transformer->convertTime();
			
 		 /// i wrzucic w output
		 $output[] = $transformer->getTournament();
 	}
  
 }
 
if (count($output)) {
	echo json_decode($output);	
}



