<?php
include "astrographics.php";
include "phpequations.class.php"; 
include 'GoogleAPI.php';
$equations = new phpequations(); 

$content="Content-type: image/svg+xml";
header($content);
echo '<?xml version="1.0" ?>';


$radix = new Astrographics;

$birthDate = $_GET['birthdate'];
$latitude = $_GET['lat'];
$longitude = $_GET['long'];
$time = $_GET['time'];

$googleInst = new GoogleAPI();
$timeZone = $googleInst->getTimeZone($longitude, $latitude);

$birtArray = explode(".", $birthDate);
$timeArray = explode(":", $time);

$date = new DateTime();
$date->setTimezone(new DateTimeZone($timeZone));
$date->setDate(intval($birtArray[2]), intval($birtArray[1]),  intval($birtArray[0]));
$date->setTime(intval($timeArray[0]),  intval($timeArray[1]),00);
$date->setTimezone(new DateTimeZone('UTC'));

//get universal time 
$gmString = $date->format("m d Y H:i:s");
$gmArray = explode(" ", $gmString);
$gmTime = explode(":", $gmArray[3]);


// XML source
$planets = $radix->get_planets("http://neu.webnagel.de/astro-xml/test/planets.php?birthdate="
        .$gmArray[1].".".$gmArray[0].".".$gmArray[2]."&long=".$longitude."&lat".$latitude."&ut=".$gmTime[0].":".$gmArray[1]);


$drawAspectsString = "";

$textMargin = 22;
$planet_info = array();

// sun
$sonne_grad = $planets['sonne_grad'];
$sonne_zodiac = $planets['sonne_zodiac'];
$sonne_arcminutes = $planets['sonne_arcminutes'];
$sonne_arc = $radix->get_arcToDraw($sonne_grad, $sonne_zodiac, $sonne_arcminutes);
$sonne_coordinates = $radix->get_radix_coordinates($sonne_arc, 280);
$sonne_x = ($sonne_coordinates['x']);
$sonne_y = ($sonne_coordinates['y'] * -1);
$sonne_descr = $radix->get_radix_coordinates($sonne_arc, 255);
$sonne_descr_x = ($sonne_descr['x']);
$sonne_descr_y = ($sonne_descr['y'] * -1);
$sunInfo = array();
$sunInfo["arc"] = $sonne_arc;
$sunInfo["planet"] = "sonne";
$sunInfo["radius"] = 280;
$planet_info[] = $sunInfo;

// moon
$mond_grad = $planets['mond_grad'];
$mond_zodiac = $planets['mond_zodiac'];
$mond_arcminutes = $planets['mond_arcminutes'];
$mond_arc = $radix->get_arcToDraw($mond_grad, $mond_zodiac, $mond_arcminutes);
$moonradius = getRadius($mond_arc, $planet_info);
$mond_coordinates = $radix->get_radix_coordinates($mond_arc, $moonradius);
$mond_x = $mond_coordinates['x'];
$mond_y = ($mond_coordinates['y'] * - 1);
$mond_descr = $radix->get_radix_coordinates($mond_arc, $moonradius - 2.4*10);
$mond_descr_x = $mond_descr['x'];
$mond_descr_y = ($mond_descr['y'] * -1);
$moonInfo = array();
$moonInfo["arc"] = $mond_arc;
$moonInfo["planet"] = "moon";
$moonInfo["radius"] = $moonradius;
$planet_info[] = $moonInfo;

$drawAspectsString .= drawAspect($mond_x, $mond_y, $sonne_x, $sonne_y, $mond_arc, $sonne_arc);

// Merkur
$merkur_grad = $planets['merkur_grad'];
$merkur_zodiac = $planets['merkur_zodiac'];
$merkur_arcminutes = $planets['merkur_arcminutes'];
$merkur_arc = $radix->get_arcToDraw($merkur_grad, $merkur_zodiac, $merkur_arcminutes);
$merkurradius = getRadius($merkur_arc, $planet_info);
$merkur_coordinates = $radix->get_radix_coordinates($merkur_arc, $merkurradius);
$merkur_x = $merkur_coordinates['x'];
$merkur_y = ($merkur_coordinates['y'] * -1);
$merkur_descr = $radix->get_radix_coordinates($merkur_arc, $merkurradius - 3*6);
$merkur_descr_x = $merkur_descr['x'];
$merkur_descr_y = ($merkur_descr['y'] * -1);
$merkurInfo = array();
$merkurInfo["arc"] = $merkur_arc;
$merkurInfo["planet"] = "merkur";
$merkurInfo["radius"] = $merkurradius;
$planet_info[] = $merkurInfo;

$drawAspectsString .= drawAspect($mond_x, $mond_y, $merkur_x, $merkur_y, $mond_arc, $merkur_arc);
$drawAspectsString .= drawAspect($merkur_x, $merkur_y, $sonne_x, $sonne_y, $merkur_arc, $sonne_arc);

// Venus
$venus_grad = $planets['venus_grad'];
$venus_zodiac = $planets['venus_zodiac'];
$venus_arcminutes = $planets['venus_arcminutes'];
$venus_arc = $radix->get_arcToDraw($venus_grad, $venus_zodiac, $venus_arcminutes);
$venusradius = getRadius($venus_arc, $planet_info);
$venus_coordinates = $radix->get_radix_coordinates($venus_arc, $venusradius);
$venus_x = $venus_coordinates['x'];
$venus_y = ($venus_coordinates['y'] * -1);
$venus_descr = $radix->get_radix_coordinates($venus_arc, $venusradius - 1.9*10);
$venus_descr_x = $venus_descr['x'];
$venus_descr_y = ($venus_descr['y'] * -1);
$venusInfo = array();
$venusInfo["arc"] = $venus_arc;
$venusInfo["planet"] = "venus";
$venusInfo["radius"] = $venusradius;
$planet_info[] = $venusInfo;

$drawAspectsString .= drawAspect($venus_x, $venus_y, $merkur_x, $merkur_y, $venus_arc, $merkur_arc);
$drawAspectsString .= drawAspect($venus_x, $venus_y, $sonne_x, $sonne_y, $venus_arc, $sonne_arc);
$drawAspectsString .= drawAspect($venus_x, $venus_y, $mond_x, $mond_y, $venus_arc, $mond_arc);

// Mars
$mars_grad = $planets['mars_grad'];
$mars_zodiac = $planets['mars_zodiac'];
$mars_arcminutes = $planets['mars_arcminutes'];
$mars_arc = $radix->get_arcToDraw($mars_grad, $mars_zodiac, $mars_arcminutes);
$marsradius = getRadius($mars_arc, $planet_info);
$mars_coordinates = $radix->get_radix_coordinates($mars_arc, $marsradius);
$mars_x = $mars_coordinates['x'];
$mars_y = $mars_coordinates['y'];
$mars_descr = $radix->get_radix_coordinates($mars_arc, $marsradius - $textMargin + 5.5 );
$mars_descr_x = $mars_descr['x'];
$mars_descr_y = $mars_descr['y'];
$marsInfo = array();
$marsInfo["arc"] = $mars_arc;
$marsInfo["planet"] = "mars";
$marsInfo["radius"] = $marsradius;
$planet_info[] = $marsInfo;

$drawAspectsString .= drawAspect($venus_x, $venus_y, $mars_x, $mars_y  * -1, $venus_arc, $mars_arc);
$drawAspectsString .= drawAspect($mars_x, $mars_y * -1, $merkur_x, $merkur_y, $mars_arc, $merkur_arc);
$drawAspectsString .= drawAspect($mars_x, $mars_y * -1, $sonne_x, $sonne_y, $mars_arc, $sonne_arc);
$drawAspectsString .= drawAspect($mars_x, $mars_y  * -1, $mond_x, $mond_y, $mars_arc, $mond_arc);

// Jupiter
$jupiter_grad = $planets['jupiter_grad'];
$jupiter_zodiac = $planets['jupiter_zodiac'];
$jupiter_arcminutes = $planets['jupiter_arcminutes'];
$jupiter_arc = $radix->get_arcToDraw($jupiter_grad, $jupiter_zodiac, $jupiter_arcminutes);
$jupiterradius = getRadius($jupiter_arc, $planet_info);
$jupiter_coordinates = $radix->get_radix_coordinates($jupiter_arc, $jupiterradius);
$jupiter_x = $jupiter_coordinates['x'];
$jupiter_y = ($jupiter_coordinates['y'] * -1);
$jupiter_descr = $radix->get_radix_coordinates($jupiter_arc, $jupiterradius - 1.9*11);
$jupiter_descr_x = $jupiter_descr['x'];
$jupiter_descr_y = ($jupiter_descr['y'] * -1);
$jupiterInfo = array();
$jupiterInfo["arc"] = $jupiter_arc;
$jupiterInfo["planet"] = "jupiter";
$jupiterInfo["radius"] = $jupiterradius;
$planet_info[] = $jupiterInfo;

$drawAspectsString .= drawAspect($jupiter_x, $jupiter_y, $mars_x, $mars_y * -1, $jupiter_arc, $mars_arc);
$drawAspectsString .= drawAspect($jupiter_x, $jupiter_y, $venus_x, $venus_y, $jupiter_arc, $venus_arc);
$drawAspectsString .= drawAspect($jupiter_x, $jupiter_y, $merkur_x, $merkur_y, $jupiter_arc, $merkur_arc);
$drawAspectsString .= drawAspect($jupiter_x, $jupiter_y, $sonne_x, $sonne_y, $jupiter_arc, $sonne_arc);
$drawAspectsString .= drawAspect($jupiter_x, $jupiter_y, $mond_x, $mond_y, $jupiter_arc, $mond_arc);

// Saturn
$saturn_grad = $planets['saturn_grad'];
$saturn_zodiac = $planets['saturn_zodiac'];
$saturn_arcminutes = $planets['saturn_arcminutes'];
$saturn_arc = $radix->get_arcToDraw($saturn_grad, $saturn_zodiac, $saturn_arcminutes);
$saturnradius = getRadius($saturn_arc, $planet_info);
$saturn_coordinates = $radix->get_radix_coordinates($saturn_arc, $saturnradius);
$saturn_x = $saturn_coordinates['x'];
$saturn_y = ($saturn_coordinates['y'] * -1);
$saturn_descr = $radix->get_radix_coordinates($saturn_arc, $saturnradius - 2.4*10);
$saturn_descr_x = $saturn_descr['x'];
$saturn_descr_y = ($saturn_descr['y'] * -1);
$saturnInfo = array();
$saturnInfo["arc"] = $saturn_arc;
$saturnInfo["planet"] = "saturn";
$saturnInfo["radius"] = $saturnradius;
$planet_info[] = $saturnInfo;

$drawAspectsString .= drawAspect($jupiter_x, $jupiter_y, $saturn_x, $saturn_y, $jupiter_arc, $saturn_arc);
$drawAspectsString .= drawAspect($saturn_x, $saturn_y, $mars_x, $mars_y * -1, $saturn_arc, $mars_arc);
$drawAspectsString .= drawAspect($saturn_x, $saturn_y, $venus_x, $venus_y, $saturn_arc, $venus_arc);
$drawAspectsString .= drawAspect($saturn_x, $saturn_y, $merkur_x, $merkur_y, $saturn_arc, $merkur_arc);
$drawAspectsString .= drawAspect($saturn_x, $saturn_y, $sonne_x, $sonne_y, $saturn_arc, $sonne_arc);
$drawAspectsString .= drawAspect($saturn_x, $saturn_y, $mond_x, $mond_y, $saturn_arc, $mond_arc);

// Uranus
$uranus_grad = $planets['uranus_grad'];
$uranus_zodiac = $planets['uranus_zodiac'];
$uranus_arcminutes = $planets['uranus_arcminutes'];
$uranus_arc = $radix->get_arcToDraw($uranus_grad, $uranus_zodiac, $uranus_arcminutes);
$uranusradius = getRadius($uranus_arc, $planet_info);
$uranus_coordinates = $radix->get_radix_coordinates($uranus_arc, $uranusradius);
$uranus_x = $uranus_coordinates['x'];
$uranus_y = ( $uranus_coordinates['y'] * -1);
$uranus_descr = $radix->get_radix_coordinates($uranus_arc, $uranusradius - 3*6);
$uranus_descr_x = $uranus_descr['x'];
$uranus_descr_y = ($uranus_descr['y'] * -1);
$uranusInfo = array();
$uranusInfo["arc"] = $uranus_arc;
$uranusInfo["planet"] = "uranus";
$uranusInfo["radius"] = $uranusradius;
$planet_info[] = $uranusInfo;

$drawAspectsString .= drawAspect($jupiter_x, $jupiter_y, $uranus_x, $uranus_y, $jupiter_arc, $uranus_arc);
$drawAspectsString .= drawAspect($uranus_x, $uranus_y, $saturn_x, $saturn_y, $uranus_arc, $saturn_arc);
$drawAspectsString .= drawAspect($uranus_x, $uranus_y, $mars_x, $mars_y * -1, $uranus_arc, $mars_arc);
$drawAspectsString .= drawAspect($uranus_x, $uranus_y, $venus_x,$venus_y, $uranus_arc, $venus_arc);
$drawAspectsString .= drawAspect($uranus_x, $uranus_y, $merkur_x, $merkur_y, $uranus_arc, $merkur_arc);
$drawAspectsString .= drawAspect($uranus_x, $uranus_y, $sonne_x, $sonne_y, $uranus_arc, $sonne_arc);
$drawAspectsString .= drawAspect($uranus_x, $uranus_y, $mond_x, $mond_y, $uranus_arc, $mond_arc);

// Neptun
$neptun_grad = $planets['neptun_grad'];
$neptun_zodiac = $planets['neptun_zodiac'];
$neptun_arcminutes = $planets['neptun_arcminutes'];
$neptun_arc = $radix->get_arcToDraw($neptun_grad, $neptun_zodiac, $neptun_arcminutes);
$neptunradius = getRadius($neptun_arc, $planet_info);
$neptun_coordinates = $radix->get_radix_coordinates($neptun_arc, $neptunradius);
$neptun_x = $neptun_coordinates['x'];
$neptun_y = ($neptun_coordinates['y'] * -1);
$neptun_descr = $radix->get_radix_coordinates($neptun_arc, $neptunradius - 2.9*8);
$neptun_descr_x = $neptun_descr['x'];
$neptun_descr_y = ($neptun_descr['y'] * -1);
$neptunInfo = array();
$neptunInfo["arc"] = $neptun_arc;
$neptunInfo["planet"] = "neptun";
$neptunInfo["radius"] = $neptunradius;
$planet_info[] = $neptunInfo;

$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $uranus_x, $uranus_y, $neptun_arc, $uranus_arc);
$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $jupiter_x, $jupiter_y, $jupiter_arc, $neptun_arc);
$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $saturn_x, $saturn_y, $neptun_arc, $saturn_arc);
$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $mars_x, $mars_y * -1, $neptun_arc, $mars_arc);
$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $venus_x,$venus_y, $neptun_arc, $venus_arc);
$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $merkur_x, $merkur_y, $neptun_arc, $merkur_arc);
$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $sonne_x, $sonne_y, $neptun_arc, $sonne_arc);
$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $mond_x, $mond_y, $neptun_arc, $mond_arc);

// Pluto
$pluto_grad = $planets['pluto_grad'];
$pluto_zodiac = $planets['pluto_zodiac'];
$pluto_arcminutes = $planets['pluto_arcminutes'];
$pluto_arc = $radix->get_arcToDraw($pluto_grad, $pluto_zodiac, $pluto_arcminutes);
$plutoradius = getRadius($pluto_arc, $planet_info);
$pluto_coordinates = $radix->get_radix_coordinates($pluto_arc, $plutoradius);
$pluto_x = $pluto_coordinates['x'];
$pluto_y = ($pluto_coordinates['y'] * -1);
$pluto_descr = $radix->get_radix_coordinates($pluto_arc, $plutoradius - 3*5);
$pluto_descr_x = $pluto_descr['x'];
$pluto_descr_y = ($pluto_descr['y'] * -1);
$plutoInfo = array();
$plutoInfo["arc"] = $pluto_arc;
$plutoInfo["planet"] = "pluto";
$plutoInfo["radius"] = $plutoradius;
$planet_info[] = $plutoInfo;

$drawAspectsString .= drawAspect($neptun_x, $neptun_y, $pluto_x, $pluto_y, $neptun_arc, $pluto_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $uranus_x, $uranus_y, $pluto_arc, $uranus_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $jupiter_x, $jupiter_y, $jupiter_arc, $pluto_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $saturn_x, $saturn_y, $pluto_arc, $saturn_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $mars_x, $mars_y * -1, $pluto_arc, $mars_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $venus_x,$venus_y, $pluto_arc, $venus_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $merkur_x, $merkur_y, $pluto_arc, $merkur_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $sonne_x, $sonne_y, $pluto_arc, $sonne_arc);
$drawAspectsString .= drawAspect($pluto_x, $pluto_y, $mond_x, $mond_y, $pluto_arc, $mond_arc);

//mondknoten
$mondknoten_grad = $planets['mondknoten_grad'];
$mondknoten_zodiac = $planets['mondknoten_zodiac'];
$mondknoten_arcminutes = $planets['mondknoten_arcminutes'];
$mondknoten_arc = $radix->get_arcToDraw($mondknoten_grad, $mondknoten_zodiac, $mondknoten_arcminutes);
$mondknotenradius = getRadius($mondknoten_arc, $planet_info);
$mondknoten_coordinates = $radix->get_radix_coordinates($mondknoten_arc, $mondknotenradius);
$mondknoten_x = $mondknoten_coordinates['x'];
$mondknoten_y = ($mondknoten_coordinates['y'] * -1);
$mondknoten_descr = $radix->get_radix_coordinates($mondknoten_arc, $mondknotenradius - 3*5);
$mondknoten_descr_x = $mondknoten_descr['x'];
$mondknoten_descr_y = ($mondknoten_descr['y'] * -1);
$mondknotenInfo = array();
$mondknotenInfo["arc"] = $mondknoten_arc;
$mondknotenInfo["planet"] = "mondknoten";
$mondknotenInfo["radius"] = $mondknotenradius;
$planet_info[] = $mondknotenInfo;

$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y,$neptun_x, $neptun_y, $mondknoten_arc,$neptun_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $pluto_x, $pluto_y, $mondknoten_arc,$neptun_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $uranus_x, $uranus_y, $mondknoten_arc, $uranus_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $jupiter_x, $jupiter_y, $mondknoten_arc,$jupiter_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $saturn_x, $saturn_y, $mondknoten_arc, $saturn_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $mars_x, $mars_y * -1, $mondknoten_arc, $mars_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $venus_x,$venus_y, $mondknoten_arc, $venus_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $merkur_x, $merkur_y, $mondknoten_arc, $merkur_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $sonne_x, $sonne_y, $mondknoten_arc, $sonne_arc);
$drawAspectsString .= drawAspect($mondknoten_x, $mondknoten_y, $mond_x, $mond_y, $mondknoten_arc, $mond_arc);

//Chiron
$chiron_grad = $planets['chiron_grad'];
$chiron_zodiac = $planets['chiron_zodiac'];
$chiron_arcminutes = $planets['chiron_arcminutes'];
$chiron_arc = $radix->get_arcToDraw($chiron_grad, $chiron_zodiac, $chiron_arcminutes);
$chironradius = getRadius($chiron_arc, $planet_info);
$chiron_coordinates = $radix->get_radix_coordinates($chiron_arc, $chironradius);
$chiron_x = $chiron_coordinates['x'];
$chiron_y = ($chiron_coordinates['y'] * -1);
$chiron_descr = $radix->get_radix_coordinates($chiron_arc, $chironradius - 3*5);
$chiron_descr_x = $chiron_descr['x'];
$chiron_descr_y = ($chiron_descr['y'] * -1);
$chironInfo = array();
$chironInfo["arc"] = $chiron_arc;
$chironInfo["planet"] = "mondknoten";
$chironInfo["radius"] = $chironradius;
$planet_info[] = $chironInfo;

$drawAspectsString .= drawAspect($chiron_x, $chiron_y,$mondknoten_x, $mondknoten_y, $chiron_arc,$mondknoten_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y,$neptun_x, $neptun_y, $chiron_arc,$neptun_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $pluto_x, $pluto_y, $chiron_arc,$neptun_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $uranus_x, $uranus_y, $chiron_arc, $uranus_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $jupiter_x, $jupiter_y, $chiron_arc,$jupiter_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $saturn_x, $saturn_y, $chiron_arc, $saturn_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $mars_x, $mars_y * -1, $chiron_arc, $mars_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $venus_x,$venus_y, $chiron_arc, $venus_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $merkur_x, $merkur_y, $chiron_arc, $merkur_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $sonne_x, $sonne_y, $chiron_arc, $sonne_arc);
$drawAspectsString .= drawAspect($chiron_x, $chiron_y, $mond_x, $mond_y, $chiron_arc, $mond_arc);

// Ascendant
$ascendant_grad = $planets['ascendant_grad'];
$ascendant_zodiac = $planets['ascendant_zodiac'];
$ascendant_arcminutes = $planets['ascendant_arcminutes'];
$ascendant_arc = $radix->get_arcToDraw($ascendant_grad, $ascendant_zodiac, $ascendant_arcminutes);
$draw_ascendant = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($ascendant_arc) .", 400,470)\" style=\"stroke:#000; stroke-width:1\" /> \n";

$drehung = $ascendant_arc - 90;


$draw_ringstart = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"100\" style=\"stroke:#cc0000; stroke-width:1\" /> \n";



// draw 360 degrees scale
$draw_scale = "<defs> \n";
$draw_scale.= "<line id=\"degrees\" x1=\"400\" y1=\"470\" x2=\"700\" y2=\"470\" style=\"stroke:#aeaeaf; stroke-width:1\" /> \n";
$draw_scale.= "<line id=\"degrees_10\" x1=\"400\" y1=\"470\" x2=\"700\" y2=\"470\" style=\"stroke:#ff0000; stroke-width:1;\" /> \n";
$draw_scale.= "<line id=\"degrees_zodiac\" x1=\"450\" y1=\"470\" x2=\"730\" y2=\"470\" style=\"stroke:#000000; stroke-width:1\"  /> \n";
$draw_scale.= "</defs> \n";

$draw_scale.= "<g> \n";
for ($i = 0; $i <= 359; $i++) {
	$arc= $i;
	$draw_scale .= "<use xlink:href=\"#degrees\" transform=\"rotate(" . $arc .", 400, 470)\" /> \n";
}
$draw_scale .= "</g> \n";

$draw_scale_10 = "<g> \n";
for ($i = 0; $i <= 35; $i++) {
	$arc= 10 * $i;
	$draw_scale_10 .= "<use xlink:href=\"#degrees_10\" transform=\"rotate(" . $arc .", 400, 470)\" /> \n";
}
$draw_scale_10 .= "</g> \n";

$draw_scale_zodiac = "<g> \n";
for ($i = 0; $i <= 11; $i++) {
	$arc= 30 * $i;
	$draw_scale_zodiac .= "<use xlink:href=\"#degrees_zodiac\" transform=\"rotate(" . $arc .", 400, 470)  \" /> \n";
}

$draw_scale_zodiac .= "</g> \n";

function getRadius($planetArc, $planetArray){
    $nearArray = array();
    foreach ($planetArray as $planet){
        if(isNear($planetArc,$planet["arc"])){
            $nearArray[] = $planet;
        }
    }
    
    if(count($nearArray) == 0){
        return 250;
    }
    else{
        if(count($nearArray) == 1){
            return $nearArray[0]["radius"] - 28;
        }
        else {
            $lowestRadius = $nearArray[0]["radius"];
            foreach ($nearArray as $nearPlanet){
                if($nearPlanet["planet"] != $nearArray[0]["planet"]){
                    if($nearPlanet["radius"] < $lowestRadius){
                        $lowestRadius = $nearPlanet["radius"];
                    }
                }
            }
            return $lowestRadius - 28;
        }
    }        
}

function isNear($planetArc, $currentArc){
    $difference = abs($planetArc - $currentArc);
    if($difference <= 10){
        return TRUE;
    }
    else{
        return FALSE;
    }        
}

function calculateParametarA($x1,$y1,$x2,$y2){
    return  ($y2-$y1)/($x2-$x1);
}

function calculateParametarB($x1,$y1,$x2,$y2){
    $differenceX = $x2-$x1;
    $differenceY = $y2-$y1;
    $firstMul = $x1 * $differenceY;
    $secondMul = $y1 * $differenceX;
    $sum = $firstMul - $secondMul;
    return $sum/$differenceX;    
}

function calculateY($parameterA,$parameterB,$x){
    return $parameterA * $x - $parameterB;
}

function getDistance($x1,$y1,$x2,$y2){
    $distanceX = $x2 - $x1;
    $distanceY = $y2 - $y1;
    return (pow($distanceX,2) + pow($distanceY,2));
}

function getYCoordinates($xcoordinates,$parA, $parB){
    $ycoordinates = array();
    
    if(count($xcoordinates) == 2){
        $firstY = calculateY($parA, $parB, $xcoordinates[0]); 
        $secondY = calculateY($parA, $parB, $xcoordinates[1]); 
        $ycoordinates[] = $firstY;
        $ycoordinates[] = $secondY;
    }
    
    return $ycoordinates;
}

function getPoint($x1,$y1,$x2,$y2){
    $parA = calculateParametarA($x1, $y1, $x2, $y2);
    $parB = calculateParametarB($x1, $y1, $x2, $y2);
    $parA2 = strval(pow($parA,2));
    $parB2 = strval(pow($parB,2));
    $parAB = strval($parA * $parB);
    $parABMultiple2 = strval($parA*$parB*2);
    $b940 = strval($parA * 940);
    $parA2PlusOne = strval(1+pow($parA,2));
    $factorX = strval(-800-940*$parA-$parA*$parB*2);
    $freeFactor = strval(366500 + 940*$parB + pow($parB,2));          
    $mineResults = solveEquation(1+pow($parA,2), -800-940*$parA-$parA*$parB*2, 355300 + 940*$parB + pow($parB,2));
    $yResutls = getYCoordinates($mineResults, $parA, $parB);    
    $pointArray = array();
    $pointArray[] = $mineResults;
    $pointArray[] = $yResutls;
    return $pointArray;
}

function solveEquation($a,$b,$c){
    $result = array();
    $b2 = pow($b,2);
    $ac4 = -4 * $a * $c;
    $sqrtVal = sqrt($b2 + $ac4);
    $a2 = 2* $a;
    $firstSolution = (-$b + $sqrtVal)/$a2;
    $secondSolution = (-$b - $sqrtVal)/$a2;
    $result[] = $firstSolution;
    $result[] = $secondSolution;
    return $result;
}

function getColor($angleDifference){    
    if(($angleDifference >= 87 && $angleDifference <=93) ||
            ($angleDifference >= 177 && $angleDifference <=183)){
        return "red";
    }        
    else if(($angleDifference >= 57 && $angleDifference <=63) ||
            ($angleDifference >= 117 && $angleDifference <=123)){
        return "blue";
    }        
    else if(($angleDifference >= 27 && $angleDifference <=33) ||
            ($angleDifference >= 147 && $angleDifference <=153)){
        return "green";
    }
    else {
        return "";
    }
}

function getRGBString($colorString){
    $rgbString = "";
        if($colorString == "red"){
            $rgbString = "rgb(255,0,0)";
        }
        else if($colorString == "green"){
            $rgbString = "rgb(0,255,0)";
        }
        else if($colorString == "blue"){
            $rgbString = "rgb(0,0,255)";
        }
        
    return $rgbString ;
}

function drawAspect($cordinateX1,$cordinateY1,$cordinateX2,$cordinateY2,$firstArc,$secondArc){
    $arcDifference = abs($secondArc-$firstArc);
    $roundedDifference = round($arcDifference);    
    $angleColor = getColor($roundedDifference);
    if(strlen($angleColor) == 0){
        return;
    }
    $lineStringDraw = "";        
        
    $lineX1 = 400 + $cordinateX1;
    $lineY1 = 470 + $cordinateY1;
    $lineX2 = 400 + $cordinateX2;
    $lineY2 = 470 + $cordinateY2;
    
    $firstPointArray = getPoint($lineX1,$lineY1,400,470);
    $secondPointArray = getPoint($lineX2, $lineY2, 400, 470);
    
    $firstCirclePoint = array();
    $secondCirclePoint = array();
       
    if(count($firstPointArray) == 2){
        $firstXCoordinates = $firstPointArray[0];
        $firstYCoordinates = $firstPointArray[1];
        if(count($firstXCoordinates) == 2 &&
                count($firstYCoordinates) == 2){
            
                $firstResultPoint = array();
                $firstResultPoint[] = $firstXCoordinates[0];
                $firstResultPoint[] = $firstYCoordinates[0];
                
                $secondResultPoint = array();
                $secondResultPoint[] = $firstXCoordinates[1];
                $secondResultPoint[] = $firstYCoordinates[1];
                
                $firstDistance = getDistance($firstResultPoint[0], $firstResultPoint[1], $lineX1, $lineY1);
                $secondDistance = getDistance($secondResultPoint[0], $secondResultPoint[1], $lineX1, $lineY1);
                if($firstDistance <= $secondDistance){
                    $firstCirclePoint[] = $firstResultPoint[0];
                    $firstCirclePoint[] = $firstResultPoint[1];
                }
                else{
                    $firstCirclePoint[] = $secondResultPoint[0];
                    $firstCirclePoint[] = $secondResultPoint[1];
                }
            }
    }
    
    if(count($secondPointArray) == 2){
        $firstXCoordinates = $secondPointArray[0];
        $firstYCoordinates = $secondPointArray[1];
        if(count($firstXCoordinates) == 2 &&
                count($firstYCoordinates) == 2){
            
                $firstResultPoint = array();
                $firstResultPoint[] = $firstXCoordinates[0];
                $firstResultPoint[] = $firstYCoordinates[0];
                
                $secondResultPoint = array();
                $secondResultPoint[] = $firstXCoordinates[1];
                $secondResultPoint[] = $firstYCoordinates[1];
                
                $firstDistance = getDistance($firstResultPoint[0], $firstResultPoint[1], $lineX2, $lineY2);
                $secondDistance = getDistance($secondResultPoint[0], $secondResultPoint[1], $lineX2, $lineY2);
                if($firstDistance <= $secondDistance){
                    $secondCirclePoint[] = $firstResultPoint[0];
                    $secondCirclePoint[] = $firstResultPoint[1];
                }
                else{
                    $secondCirclePoint[] = $secondResultPoint[0];
                    $secondCirclePoint[] = $secondResultPoint[1];
                }
            }
    }
        
    if(count($firstCirclePoint) == 2 && count($secondCirclePoint) == 2){
        $rgbString = getRGBString($angleColor);
                       
        //<line xmlns="http://www.w3.org/2000/svg" x1="228" y1="360" x2="428" y2="267"
        // style="stroke:rgb(255,0,0);stroke-width:4" transform="rotate(0, 400,470)"/>
        
        $lineStringDraw .= "<line xmlns=\"http://www.w3.org/2000/svg\" x1=\"".$firstCirclePoint[0]."\" y1=\"".$firstCirclePoint[1].
                "\" x2=\"".$secondCirclePoint[0]."\" y2=\"".$secondCirclePoint[1].
                "\" style=\"stroke:".$rgbString.";stroke-width:2\" transform=\"rotate(0, 400,470)\" />";                
        $lineStringDraw .= "\n";        
    }               
    
    return $lineStringDraw;
}


function get_x($arc, $radius) {
	$rad = $arc / 180 * pi();
	 $x = $radius * cos ($rad);
	 return $x;
}
function get_y($arc, $radius) {
	$rad = $arc / 180 * pi();
	 $y = $radius * sin ($rad);
	 return $y;
}

function getCorrectionIndex($coordinate_x, $coordinate_y){
    if(($coordinate_x < 0 && $coordinate_y > 0) ||
            ($coordinate_x > 0 && $coordinate_y < 0)){
        return 2.5;
    } 
    else if(($coordinate_x < 0 && $coordinate_y < 0)){
        return 0;
    }
    else {
        return 1;
    }
}


//dotted line
$linestyle = "style=\"stroke:#959595; stroke-width:1\" stroke-dasharray=\"1,2\"";
$linestyle2 = "style=\"stroke:red; stroke-width:1\" stroke-dasharray=\"1,2\"";

$correction_x = 0;
$correction_y = 0;

$imagewidth = 40;
$imageheight = 40;

$imagex=380;
$imagey=458;

$imagexPluto = 400;
$imagexMondKnoten = 370;

//sun
$draw_sun_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". $sonne_arc .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_sun_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" . strval(floatval($sonne_x))  . ", " . strval(floatval($sonne_y))  . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"sun.svg\" ></image>";

//moon
$draw_mond_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($mond_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_mond_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($mond_x)) . ", " . strval(floatval($mond_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470)  \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"moon.svg\" ></image>";

//merkur
$draw_merkur_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($merkur_arc) .", 400,470)\" ". $linestyle . " /> \n";
$draw_merkur_symbol ="<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($merkur_x)) . ", " . strval(floatval($merkur_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"mercury.svg\" ></image>";

//venus
$draw_venus_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($venus_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_venus_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($venus_x)) . ", " . strval(floatval($venus_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"venus.svg\" ></image>";

//Mars
$draw_mars_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($mars_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_mars_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($mars_x)) . ", " . strval(floatval($mars_y * - 1)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"mars.svg\" ></image>";

//Jupiter
$draw_jupiter_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($jupiter_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_jupiter_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($jupiter_x)) . ", " . strval(floatval($jupiter_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"jupiter.svg\" ></image>";

//Saturn
$draw_saturn_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". $saturn_arc .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_saturn_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($saturn_x)) . ", " . strval(floatval($saturn_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"saturn.svg\" ></image>";

//Uranus
$draw_uranus_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($uranus_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_uranus_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($uranus_x)) . ", " . strval(floatval($uranus_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"uranus.svg\" ></image>";

//Neptun
$draw_neptun_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($neptun_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_neptun_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($neptun_x)) . ", " . strval(floatval($neptun_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"neptune.svg\" ></image>";

//Pluto
$draw_pluto_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($pluto_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_pluto_symbol = "<image x=\"".$imagexPluto."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($pluto_x)) . ", " . strval(floatval($pluto_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"pluto.svg\" ></image>";

//mond knoten
$draw_mondknoten_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($mondknoten_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_mondknoten_symbol = "<image x=\"".$imagexMondKnoten."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($mondknoten_x)) . ", " . strval(floatval($mondknoten_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"lunar_node.svg\" ></image>";

//chiron
$draw_chiron_line = "<line x1=\"400\" y1=\"470\" x2=\"400\" y2=\"175\" transform=\"rotate(-". ($chiron_arc) .", 400,470)\" ". $linestyle2 . " /> \n";
$draw_chiron_symbol = "<image x=\"".$imagex."\" y=\"".$imagey."\" transform=\"translate(" .   strval(floatval($chiron_x)) . ", " . strval(floatval($chiron_y)) . ") rotate (" . ($drehung * - 1)  . ", 400, 470) \" width=\"" .$imagewidth. "\" height=\"" . $imageheight ."\" xlink:href=\"chiron.svg\" ></image>";

$zodiac_symbols = "<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y= \"470\" class=\"\" transform=\"translate(-95.57058115441, -295.58223813131) rotate (-15.8, 400, 470)  \" style=\"font-weight:bold\">Aries</text>";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(-235.57058115441, -200.58223813131) rotate (-43.8, 400, 470)  \" style=\"font-weight:bold\" >Taurus</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(-305.57058115441, -60.58223813131) rotate (-72.8, 400, 470)  \" style=\"font-weight:bold\" >Gemini</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(-290.57058115441, 103.58223813131) rotate (-107.8, 400, 470)  \" style=\"font-weight:bold\" >Cancer</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(-207.57058115441, 228.58223813131) rotate (-132.8, 400, 470)  \" style=\"font-weight:bold\" >Leo</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(-70.57058115441, 300.58223813131) rotate (-165, 400, 470)  \" style=\"font-weight:bold\">Virgo</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(100.57058115441, 293.58223813131) rotate (-195, 400, 470)  \" style=\"font-weight:bold\">Libra</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(238.57058115441, 195.58223813131) rotate (-225, 400, 470)  \" style=\"font-weight:bold\" >Scorpio</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(310.57058115441, 45.58223813131) rotate (-255, 400, 470)  \" style=\"font-weight:bold\">Sagittarius</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(290.57058115441, -114.58223813131) rotate (-284, 400, 470)  \" style=\"font-weight:bold\" >Capricorn</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(190.57058115441, -243.58223813131) rotate (-318, 400, 470)  \" style=\"font-weight:bold\">Aquarius</text> ";
$zodiac_symbols .="<text xmlns=\"http://www.w3.org/2000/svg\" x=\"400\" y=\"470\" class=\"\" transform=\"translate(65.57058115441, -305.58223813131) rotate (-343, 400, 470)  \" style=\"font-weight:bold\">Pisces</text>";

?> 
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800" height="1200">
<title>Radix</title> 
<desc>Aktuelle Planetenpositionen</desc>
<style type="text/css" >
	<![CDATA[

	text.inputdata {
		font-family:Arial, Helvetica, sans-serif;
		font-size:10px;

	}
	text.title {
		text-anchor: middle;
		font-family:Arial, Helvetica, sans-serif;
		font-size:20px;

	}
	text.subtitle {
		text-anchor: middle;
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;

	}
	text.small {
		font-family:Arial, Helvetica, sans-serif;
		font-size:9px;

	}
	text.planet_descr {
		text-anchor: middle;
		font-family:Arial, Helvetica, sans-serif;
		font-size:9px;

	}

	]]>
</style>


<!-- background-->
<rect x="0" y="0" width="800" height="1200" fill="#ffffff" stroke="black" />

<!-- title -->
<text x="400" y="40" class="title">Radixhoroskop</text>

<!-- input data-->

<!-- <text x="400" y="60" class="subtitle"><?php echo $birthdate . ", lat: ". $lat . ", long: " . $long . ", UT: " . $ut . ", MEZ: " . $uhrzeit . " Uhr"; ?></text> -->

<text y="50" class="inputdata">
		<tspan x="40" dy="10">Aszendent Winkel: <?php echo $ascendant_arc . ", Drehung: " . $drehung; ?></tspan>
        <tspan x="40" dy="10">Sonne Winkel: <?php echo $sonne_arc; ?></tspan>
		<tspan x="40" dy="10">Mond Winkel: <?php echo $mond_arc; ?></tspan>
		<tspan x="40" dy="10">Merkur Winkel: <?php echo $merkur_arc; ?></tspan>
		<tspan x="40" dy="10">Venus Winkel: <?php echo $venus_arc; ?></tspan>
		<tspan x="40" dy="10">Mars Winkel: <?php echo $mars_arc; ?></tspan>
		<tspan x="40" dy="10">Jupiter Winkel: <?php echo $jupiter_arc; ?></tspan>
		<tspan x="40" dy="10">Saturn Winkel: <?php echo $saturn_arc; ?></tspan>
		<tspan x="40" dy="10">Uranus Winkel: <?php echo $uranus_arc; ?></tspan>
		<tspan x="40" dy="10">Neptun Winkel: <?php echo $neptun_arc; ?></tspan>
		<tspan x="40" dy="10">Pluto Winkel: <?php echo $pluto_arc; ?></tspan>
                <tspan x="40" dy="10">Mond Knoten Winkel: <?php echo $mondknoten_arc; ?></tspan>
                <tspan x="40" dy="10">Chiron Winkel: <?php echo $chiron_arc; ?></tspan>
	
</text>

<!-- Radix -->
<?php
// Radix drehen, bis Aszendent links ist
echo "<g transform=\"rotate(". ($drehung) .", 400,470)\">";
?>



<!-- circle -->
<circle cx="400" cy="470" r="330" stroke="black" stroke-width="1" fill="#ffffff" />

<!-- scales -->
<?php
echo $draw_scale;
echo $draw_scale_10;
echo $draw_scale_zodiac;
?>
<circle cx="400" cy="470" r="300" stroke="#cccccc" stroke-width="1" fill="none" />
<!-- mask -->
<circle cx="400" cy="470" r="295" stroke="#cccccc" stroke-width="1" fill="#ffffff" />





<?php

echo $draw_ascendant;
echo $draw_ringstart;

echo $draw_sun_line;
echo $draw_sun_symbol;

echo $draw_mond_line;
echo $draw_mond_symbol;

echo $draw_merkur_line;
echo $draw_merkur_symbol;

echo $draw_venus_line;
echo $draw_venus_symbol;

echo $draw_mars_line;
echo $draw_mars_symbol;

echo $draw_jupiter_line;
echo $draw_jupiter_symbol;

echo $draw_saturn_line;
echo $draw_saturn_symbol;

echo $draw_uranus_line;
echo $draw_uranus_symbol;

echo $draw_neptun_line;
echo $draw_neptun_symbol;

echo $draw_pluto_line;
echo $draw_pluto_symbol;

echo $draw_mondknoten_line;
echo $draw_mondknoten_symbol;

echo $draw_chiron_line;
echo $draw_chiron_symbol;

echo $drawAspectsString; 
echo $zodiac_symbols;
?>

<!-- inner circles -->
<circle cx="400" cy="470" r="160" stroke="#cccccc" stroke-width="1" fill="none" />
<circle cx="400" cy="470" r="12" stroke="#ffffff" stroke-width="1" fill="#3363ff" />
<circle cx="400" cy="470" r="10" stroke="#ffffff" stroke-width="1" fill="none" />

<!-- Radix Ende -->
</g>
</svg>