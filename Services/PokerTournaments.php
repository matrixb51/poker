<?php

// liczba pojedycnza w nazwiej obiektu
// nazwa obiekt mowi nam o odpowiedzialnosci obiektu.
// czyli dobra nazwa to: TournametsDataTransformer bo to ma byc wszystko co ten obiekt ma robic! brac dane i wypluwac przefiltrowane
// ten obiekt ma:


class PokerTournaments {
   
    //protected jest zle ($tournaments wyglada lepiej niz $_tournaments) 
    protected $_tournaments;

   // dzialamy na jednym tournament na raz!
    public function __construct($tournaments) {        
        $this->_tournaments = $tournaments;
    }
    
    public function getTournaments() {
        return $this->_tournaments;
    }
    
    public function getFilteredTournaments($filters) {
    	//dlaczego self? self jest do metod statycznych nie chcemy metod statycznch daj $this->filterToru....
        return self::_filter($filters);
    }
	
	
    
	//nazwa metody mowi co sie dzieje czyli filterTournamentsWithXpropertyBelowYValue
    private function _filter($filters){
        
        $result = array();
        
		//Ten obiekt dziala tylko na jednym tournamencie i nie ma zielonego pojdzcie jakie
		// sa inne tournamenty. Po co ma wiedziec o wszysgtkich tournamentach skoro ma sie zajac tylko jednym?
		// do obiektow przeetwarzajacych dane zawsze idzie najmniejsza mozliwa porcja danych! 
        foreach($this->_tournaments as $tournament) {
            
			
            $valid_tournament = TRUE;
            /*
nie kombinuj tutaj tylko w kazdym obiekcie sprawdz czy wartosc jest powyzej wymaganej i jezeli to zwroc false
metody ilter_var nie uzywaj to sa jakies phpowe wynalazki tylko zaciemniajace logike
to ma byc:
			if ($tournament->zminna < integre ) {
				pomin
			} else {
				wstaw do nowej tablicy
			}

						

			 siwtch nam  z tad wylecie 
			 insturkcja siwtch jest zla!
			
			*/
			
            foreach($filters as $type => $filter) {
                switch($type){
                    case 'INTEGER_VALUES':
						
                        if( !filter_var($tournament[$filter[0]], FILTER_VALIDATE_INT, array('options'=>$filter[1])) ) {
                            $valid_tournament = FALSE;
                        }
                        break;
                }
            } 
            
            if ($valid_tournament) array_push ($result, $tournament);
        }
		
		// zamiast zwracc niech ustawia w obiekcie
         // uzywaj $this->result wtedy bedziesz mogl sie do tego odwolac w innej metodzie!
        return $result;
    }

    //tutaj inne motedy ktore robia cos ze strefa czasowa i  przeliczaja walute sygnatury sa puste bo mamy juz wysztko co potrzeba!
    // na sam koniec wyciagasz przetworzone wartosci getterem
    public function convertCurrenc()
	{
		
	}

    public function convertTime()
	{
		//zakladajac ze cos takiego jest potrzbene nie chce mi sie czygtac jeszcze raz zadania
		
		
	}
	

    
}
