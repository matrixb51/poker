<?php

class Transformer {
    
    protected $currencyRates = array();
    protected $baseCurrency = 'EUR';
    
    protected $tournament;


    public function __construct($cRates) {
        if(is_array($cRates)) {
            $this->currencyRates = $cRates['outcome'];
        }
    }
    
    public function setTournament($t){
        $this->tournament = $t;
    }
    
    public function getTournament(){
        $returnObject = new stdClass();
        die(var_dump( $this->tournament->{'@attributes'}->game_id ));
      //  $returnObject->game_id = $this->tournament->@attributes->game_id;
        $returnObject->name = $this->tournament->name;
        $returnObject->game_type = $this->tournament->game_type;
        $returnObject->buy_in = $this->tournament->buy_in;
        $returnObject->gameentry_fee = $this->tournament->entry_fee;
        $returnObject->bounty = $this->tournament->bounty;
        $returnObject->bounty_type = $this->tournament->bounty_type;
        $returnObject->entrants = $this->tournament->entrants;
        $returnObject->total_prizepool = $this->tournament->total_prizepool;
        $returnObject->registration = $this->tournament->registration;
        $returnObject->start_time = $this->tournament->start_time;
        
        return $this->tournament;
    }    
    
    public function convertCurrency($initial_currency, $expected_currency){
        $rate = 1.00;
        if(!$initial_currency === $this->baseCurrency) {
            $rate = $rate / round($this->currencyRates[$initial_currency], 2);
        }
        
        $rate = $rate * round($this->currencyRates[$expected_currency], 2);
        
        $this->tournament->buy_in = $this->tournament->buy_in * $rate;
        $this->tournament->entry_fee = $this->tournament->entry_fee * $rate;
        $this->tournament->bounty = $this->tournament->bounty * $rate;
        $this->tournament->total_prizepool = $this->tournament->total_prizepool * $rate;
        
        if($initial_currency === 'USD') {
            $this->tournament->name = preg_replace('/\$(\w+)/', '$1'.$expected_currency , $this->tournament->name);
            
        } else {
            $this->tournament->name = preg_replace('/'.$initial_currency.'/', $expected_currency , $this->tournament->name);
        }
    }
    
    public function convertTime(){
        $dateTimeZoneNY = new DateTimeZone("America/New_York");
        $dateTimeZoneMalta = new DateTimeZone("Europe/Malta");

        $registrationTimeNY = DateTime::createFromFormat('Y-m-d*H:i:s', substr($this->tournament->registration,0,-6), $dateTimeZoneNY);

        $registrationTimeNY->setTimeZone($dateTimeZoneMalta);

        $this->tournament->registration = $registrationTimeNY->format('Y-m-d H:i:s-H:i');

        $startTimeNY = DateTime::createFromFormat('Y-m-d*H:i:s', substr($this->tournament->registration,0,-6), $dateTimeZoneNY);
        $startTimeNY->setTimeZone($dateTimeZoneMalta);
        $this->tournament->start_time = $startTimeNY->format('Y-m-d H:i:s-H:i');
    }
    
}