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

$tournamentsXML = simplexml_load_string($feeder->sendRequest($poker_feed_url));
$PokerTournaments = new PokerTournaments($tournamentsXML);
$tournaments = $PokerTournaments->getFilteredTournaments($tournaments_filters);


//$currency_rates = simplexml_load_string($feeder->sendRequest($currency_feed_url));

var_dump(count($tournaments));

