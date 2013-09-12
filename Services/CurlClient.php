<?php


class CurlClient 
{
    protected $status;

    public function __construct($requestUrl = NULL)
    {
        if($requestUrl) {
            $this->requestUrl = $requestUrl;
        }
        return $this;
    }

    function sendRequest($queryUrl = NULL, $action = 'GET', $header = 0)
    {        
        $httpHeaders = array('Content-Type: application/xml');

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
            print_r($status);
            return $result;
        }
        curl_close($ch);
        
        return NULL;
    }
    
  

    function getStatus()
    {
        return $this->status;
    }
}
