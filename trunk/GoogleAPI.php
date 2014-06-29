<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GoogleAPI
 *
 * @author nn
 */
class GoogleAPI {
    //put your code here
    public function __construct() {
        
    }
    
    public function getCities($city, $country){
        $results = array();
        
        $urlToReturn = "";
        $urlToReturn .= "https://maps.googleapis.com/maps/api/geocode/json?address=";
        $urlToReturn .= $city;
        $urlToReturn .= "&sensor=false&components=country:";
        $urlToReturn .= $country;
        $urlToReturn .= "&key=AIzaSyC-eCjYJLdMlfPR_lJVoAjfKTpkXf6mwGY";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlToReturn);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
        $rawResponse = curl_exec($ch);
        $response = json_decode($rawResponse, true);        
        
        // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
        if ($response['status'] != 'OK') {
         return $results;
        }

        foreach ($response["results"] as $jsonresult){
            $address = $jsonresult["formatted_address"];
            $longitude = $jsonresult["geometry"]["location"]["lng"];
            $latitude = $jsonresult["geometry"]["location"]["lat"];
            $result = array();
            $result["name"] = $address;
            $result["longitude"] = $longitude;
            $result["latitude"] = $latitude;            
            $results[] = $result;
        }
                        
        return $results;
    }
    
    public function getTimeZone($longitude, $latitude){
        //https://maps.googleapis.com/maps/api/timezone/xml?location=43.9,21.3&timestamp=1399992104&sensor=false&key=AIzaSyC-eCjYJLdMlfPR_lJVoAjfKTpkXf6mwGY
        $timeZone = "";
        
        $date = new DateTime();
        $timeStamp = $date->getTimestamp();
        
        $urlToReturn = "";
        $urlToReturn .= "https://maps.googleapis.com/maps/api/timezone/json?location=";
        $urlToReturn .= $latitude.",".$longitude;
        $urlToReturn .= "&timestamp=".$timeStamp."&sensor=false";        
        $urlToReturn .= "&key=AIzaSyC-eCjYJLdMlfPR_lJVoAjfKTpkXf6mwGY";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlToReturn);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
        $rawResponse = curl_exec($ch);
        $response = json_decode($rawResponse, true);        
        
        
        if ($response['status'] != 'OK') {
         return "Europe/Berlin";
        }
        
        $timeZone = $response['timeZoneId'];
        
        return $timeZone;
    }
}
