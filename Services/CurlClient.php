<?php


class CurlClient 
{
    protected $status;

   //skoro $requestUrl to dlaczego wartosc domyslna jest innego typu?
   // powinno byc $requestUrl = '' NULL idzie tylko dla obiektow. stringi maja '', integery maja 0  tablice maja array() (pusta taqblica) itd
    public function __construct($requestUrl = NULL)
    {
    	//if ($requestUrl != '')
        if($requestUrl) {
            $this->requestUrl = $requestUrl;
        }
		
		// dobry konstruktor nieczego nie zwraca bo nie musi ;)
        return $this;
    }

//$queryUrl to strnig wiec ''

//Czy obslugujemy inne metody HTTP niz GET? jezeli nie to poco ten parametr?
//Czy obslugujemy header inny niz zero jezeli nie to po co ten parametr?
    function sendRequest($queryUrl = NULL, $action = 'GET', $header = 0)
    {        
        $httpHeaders = array('Content-Type: application/xml');

//czy nie wystarczyl by jeden url na domene z query? po co to dzielic skoro logika taka prosta?
// wywal url z konstruktora a zostaw $queryUrl

        if($queryUrl) {
            $url = $queryUrl;
        } else $url = $this->requestUrl;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $header);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
        if (!$result = curl_exec($ch)) {
            throw new Exception(sprintf('Query call "%s" returned error: "%s"', $url, curl_error($ch)));
        } else {
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $this->status = $status;
            if ($status !== 200) {
                throw new Exception(sprintf('Query call "%s" returned error code %s: "%s"', $url, $status, $result));
            }
			//mozemy logowac do pliku wyswietlac NIGDY!
            print_r($status);
            return $result;
        }
        curl_close($ch);
        
		// null sie sam zwraca.
        return NULL;
    }
    
  

    function getStatus()
    {
        return $this->status;
    }
}
