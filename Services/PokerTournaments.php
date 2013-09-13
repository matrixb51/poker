<?php

class PokerTournaments {
   
    protected $_tournaments;

    public function __construct($tournaments) {        
        $this->_tournaments = $tournaments;
    }
    
    public function getTournaments() {
        return $this->_tournaments;
    }
    
    public function getFilteredTournaments($filters) {
        return self::_filter($filters);
    }
    
    private function _filter($filters){
        
        $result = array();
        
        foreach($this->_tournaments as $tournament) {
            
            $valid_tournament = TRUE;
            
            foreach($filters as $type => $filter) {
                switch($type){
                    case 'INTEGER_VALUES':
                        foreach($filter as $field => $conditions) {
                            if( !filter_var((int)$tournament->$field, FILTER_VALIDATE_INT, array('options'=>$conditions)) ) {
                                $valid_tournament = FALSE;
                            }   
                        }

                        break;
                }
            } 
            
            if ($valid_tournament) array_push ($result, $tournament);
        }
        return $result;
    }
}
