<?php
class Astrographics {
	
	/**
	get planet-data from xml	
	**/
	function get_planets ($xml_link) {
		
		$xml = simplexml_load_file($xml_link);
		
		//metadata
		$birthdate = $xml->metadata->birthdate;
		$lat = $xml->metadata->lat;
		$long = $xml->metadata->long;
		$ut = $xml->metadata->ut;
	
		$sonne_grad = $xml->Sun->degrees;
		$sonne_zodiac = $xml->Sun->zodiac;
		$sonne_arcminutes = $xml->Sun->arcminutes;
	
		$mond_grad = $xml->Moon->degrees;
		$mond_zodiac = $xml->Moon->zodiac;
		$mond_arcminutes = $xml->Moon->arcminutes;

		$merkur_grad = $xml->Mercury->degrees;
		$merkur_zodiac = $xml->Mercury->zodiac;
		$merkur_arcminutes = $xml->Mercury->arcminutes;
	
		$venus_grad = $xml->Venus->degrees;
		$venus_zodiac = $xml->Venus->zodiac;
		$venus_arcminutes = $xml->Venus->arcminutes;

		$mars_grad = $xml->Mars->degrees;
		$mars_zodiac = $xml->Mars->zodiac;
		$mars_arcminutes = $xml->Mars->arcminutes;

		$jupiter_grad = $xml->Jupiter->degrees;
		$jupiter_zodiac = $xml->Jupiter->zodiac;
		$jupiter_arcminutes = $xml->Jupiter->arcminutes;

		$saturn_grad = $xml->Saturn->degrees;
		$saturn_zodiac = $xml->Saturn->zodiac;
		$saturn_arcminutes = $xml->Saturn->arcminutes;	

		$uranus_grad = $xml->Uranus->degrees;
		$uranus_zodiac = $xml->Uranus->zodiac;
		$uranus_arcminutes = $xml->Uranus->arcminutes;	

		$neptun_grad = $xml->Neptune->degrees;
		$neptun_zodiac = $xml->Neptune->zodiac;
		$neptun_arcminutes = $xml->Neptune->arcminutes;

		$pluto_grad = $xml->Pluto->degrees;
		$pluto_zodiac = $xml->Pluto->zodiac;
		$pluto_arcminutes = $xml->Pluto->arcminutes;

		$mondknoten_grad = $xml->true_Node->degrees;
		$mondknoten_zodiac = $xml->true_Node->zodiac;
		$mondknoten_arcminutes = $xml->true_Node->arcminutes;

		$chiron_grad = $xml->Chiron->degrees;
		$chiron_zodiac = $xml->Chiron->zodiac;
		$chiron_arcminutes = $xml->Chiron->arcminutes;
		
		$ascendant_grad = $xml->Ascendant->degrees;
		$ascendant_zodiac = $xml->Ascendant->zodiac;
		$ascendant_arcminutes = $xml->Ascendant->arcminutes;
		
		$values = array (
		"birthdate" => $birthdate, "lat" => $lat, "long" => $long, "ut" => $ut,
		"sonne_grad" => $sonne_grad, "sonne_zodiac" => $sonne_zodiac, "sonne_arcminutes" => $sonne_arcminutes, 
		"mond_grad" => $mond_grad, "mond_zodiac" => $mond_zodiac, "mond_arcminutes" => $mond_arcminutes, 
		"merkur_grad" => $merkur_grad, "merkur_zodiac" => $merkur_zodiac, "merkur_arcminutes" => $merkur_arcminutes,
		"venus_grad" => $venus_grad, "venus_zodiac" => $venus_zodiac, "venus_arcminutes" => $venus_arcminutes,
		"mars_grad" => $mars_grad, "mars_zodiac" => $mars_zodiac, "mars_arcminutes" => $mars_arcminutes,
		"jupiter_grad" => $jupiter_grad, "jupiter_zodiac" => $jupiter_zodiac, "jupiter_arcminutes" => $jupiter_arcminutes,
		"saturn_grad" => $saturn_grad, "saturn_zodiac" => $saturn_zodiac, "saturn_arcminutes" => $saturn_arcminutes,
		"uranus_grad" => $uranus_grad, "uranus_zodiac" => $uranus_zodiac, "uranus_arcminutes" => $uranus_arcminutes, 
		"neptun_grad" => $neptun_grad, "neptun_zodiac" => $neptun_zodiac, "neptun_arcminutes" => $neptun_arcminutes, 
		"pluto_grad" => $pluto_grad, "pluto_zodiac" => $pluto_zodiac, "pluto_arcminutes" => $pluto_arcminutes, 
		"mondknoten_grad" => $mondknoten_grad, "mondknoten_zodiac" => $mondknoten_zodiac, "mondknoten_arcminutes" => $mondknoten_arcminutes,
		"chiron_grad" => $chiron_grad, "chiron_zodiac" => $chiron_zodiac, "chiron_arcminutes" => $chiron_arcminutes,
		"ascendant_grad" => $ascendant_grad, "ascendant_zodiac" => $ascendant_zodiac, "ascendant_arcminutes" => $ascendant_arcminutes
		);
			
		return $values;
		
	}
	
	/**
	calculate xy-coordinate to draw planets in radix.
	**/
	function get_radix_coordinates ($arc, $radius) {
		
		// transform arc in coordinate-system to calculate xy-position of planet-symbol
		$arc = floatval($arc + 90);
		
		$radx = $arc / 180 * pi();                                
	 	$x = $radius * cos ($radx);

		$rady = $arc / 180 * pi();                                
	 	$y = $radius * sin ($rady);
		
		$values = array ("x" => $x, "y" => $y);
		return $values;
	
	}
                			
	/**
	get degrees to draw elements in radix	
	**/
	function get_arcToDraw ($degrees, $zodiac, $arcminutes) {
		
	
		// zodiac degrees
		switch ($zodiac) {
   		case "ar":
        	$zdegrees = 0;
        	break;
    	case "ta":
        	$zdegrees = 30;
        	break;
    	case "ge":
        	$zdegrees = 60;
        	break;
		case "cn":
        	$zdegrees = 90;
        	break;
		case "le":
        	$zdegrees = 120;
        	break;
		case "vi":
        	$zdegrees = 150;
        	break;
		case "li":
        	$zdegrees = 180;
        	break;
		case "sc":
        	$zdegrees = 210;
        	break;
		case "sa":
        	$zdegrees = 240;
        	break;
		case "cp":
        	$zdegrees = 270;
        	break;		
		case "aq":
        	$zdegrees = 300;
        	break;	
		case "pi":
        	$zdegrees = 330;
        	break;
		}
	
		
		// add zodiacdregrees to degrees
		$degrees = $degrees + $zdegrees;
		
		// get arcminutes
		$arcminute = explode('\'', $arcminutes);
		$arcminute = $arcminute[0];

		// convert arcminute in degrees
		$arcminute_in_degrees = $arcminute / 60;

		// add arcminute to degrees
		$degrees = $degrees + $arcminute_in_degrees;
		
		// round 1 decimal place
		$degrees = round ($degrees, 1);

		return ($degrees);
		
		
	}
			
}

?>