<?php

class TournamentValidator {
    
    public function isValid($t) {
        
    if ($t->total_prizepool <= 1000) { return false; }
    
    return true;
    }
}