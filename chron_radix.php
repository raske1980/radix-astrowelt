<?php
include "astrographics.php";
include 'GoogleAPI.php';

$content="Content-type: image/svg+xml";
header($content);
echo '<?xml version="1.0" ?>';

$datum = date("d.m.Y");

$radix = new Astrographics;

$birthDate = $datum ;
$latitude = '51.133333';
$longitude = '10.416667';
$time = '06:00';

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
        .$gmArray[1].".".$gmArray[0].".".$gmArray[2]."&long=".$longitude."&lat".$latitude."&ut=".$gmTime[0].":".$gmTime[1]);


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


//planet table
$link = "http://neu.webnagel.de/astro-xml/test/planets.php?birthdate="
        .$gmArray[1].".".$gmArray[0].".".$gmArray[2]."&long=".$longitude."&lat".$latitude."&ut=".$gmTime[0].":".$gmTime[1];

$xml = simplexml_load_file($link);
$birthdate = $xml->metadata->birthdate;
$ut = $xml->metadata->ut;

$sonne_grad_table = $xml->Sun->degrees;
$sonne_zodiac_table = $xml->Sun->zodiac;
$sonne_arcminutes_table = $xml->Sun->arcminutes;

$mond_grad_table = $xml->Moon->degrees;
$mond_zodiac_table = $xml->Moon->zodiac;
$mond_arcminutes_table = $xml->Moon->arcminutes;

$merkur_grad_table = $xml->Mercury->degrees;
$merkur_zodiac_table = $xml->Mercury->zodiac;
$merkur_arcminutes_table = $xml->Mercury->arcminutes;

$venus_grad_table = $xml->Venus->degrees;
$venus_zodiac_table = $xml->Venus->zodiac;
$venus_arcminutes_table = $xml->Venus->arcminutes;

$mars_grad_table = $xml->Mars->degrees;
$mars_zodiac_table = $xml->Mars->zodiac;
$mars_arcminutes_table = $xml->Mars->arcminutes;

$jupiter_grad_table = $xml->Jupiter->degrees;
$jupiter_zodiac_table = $xml->Jupiter->zodiac;
$jupiter_arcminutes_table = $xml->Jupiter->arcminutes;

$saturn_grad_table = $xml->Saturn->degrees;
$saturn_zodiac_table = $xml->Saturn->zodiac;
$saturn_arcminutes_table = $xml->Saturn->arcminutes;

$uranus_grad_table = $xml->Uranus->degrees;
$uranus_zodiac_table = $xml->Uranus->zodiac;
$uranus_arcminutes_table = $xml->Uranus->arcminutes;

$neptun_grad_table = $xml->Neptune->degrees;
$neptun_zodiac_table = $xml->Neptune->zodiac;
$neptun_arcminutes_table = $xml->Neptune->arcminutes;

$pluto_grad_table = $xml->Pluto->degrees;
$pluto_zodiac_table = $xml->Pluto->zodiac;
$pluto_arcminutes_table = $xml->Pluto->arcminutes;

$mondknoten_grad_table = $xml->true_Node->degrees;
$mondknoten_zodiac_table = $xml->true_Node->zodiac;
$mondknoten_arcminutes_table = $xml->true_Node->arcminutes;

$chiron_grad_table = $xml->Chiron->degrees;
$chiron_zodiac_table = $xml->Chiron->zodiac;
$chiron_arcminutes_table = $xml->Chiron->arcminutes;


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
<g transform="translate(100,850)">
<rect x="0" y="100" width="600" height="235" style="stroke: #000; fill:none;" />
<rect x="0" y="100" width="600" height="50" style="stroke: #000; fill:#fff;" />
<rect x="0" y="150" width="600" height="50" style="stroke: #000; fill:#68c1ec;" />
<rect x="0" y="200" width="600" height="50" style="stroke: #000; fill:#fc9a00;" />
<rect x="0" y="247" width="600" height="90" style="stroke: #000; fill:#215fa3;" />
<line x1="0" y1="150" x2="600" y2="150" style="stroke:black;stroke-width:1" />
<line x1="0" y1="200" x2="600" y2="200" style="stroke:black;stroke-width:1" />



<text x="359" y="350" fill="black" style="font-family:Verdana; font-size:12px"><?php echo "Datenermittlung: " . $birthdate . ", 6:00 Uhr"; ?></text>

<text x="25" y="80" fill="black" transform="rotate(-90 25,80)" style="font-family:Verdana; font-size:12px">Sonne</text>
<text x="10" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $sonne_grad_table; ?></text>
<text x="10" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $sonne_zodiac_table; ?></text>
<text x="25" y="330" fill="white" transform="rotate(-90 25,330)" style="font-family:Verdana; font-size:12px;"><?php echo $sonne_arcminutes_table; ?></text>


<text x="75" y="80" fill="black" transform="rotate(-90 75,80)" style="font-family:Verdana; font-size:12px">Mond</text>
<text x="60" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mond_grad_table; ?></text>
<text x="60" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mond_zodiac_table; ?></text>
<text x="75" y="330" fill="white" transform="rotate(-90 75,330)" style="font-family:Verdana; font-size:12px"><?php echo $mond_arcminutes_table; ?></text>

<text x="125" y="80" fill="black" transform="rotate(-90 125,80)" style="font-family:Verdana; font-size:12px">Merkur</text>
<text x="110" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $merkur_grad_table; ?></text>
<text x="110" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $merkur_zodiac_table; ?></text>
<text x="125" y="330" fill="white" transform="rotate(-90 125,330)" style="font-family:Verdana; font-size:12px"><?php echo $merkur_arcminutes_table; ?></text>

<text x="175" y="80" fill="black" transform="rotate(-90 175,80)" style="font-family:Verdana; font-size:12px">Venus</text>
<text x="160" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $venus_grad_table; ?></text>
<text x="160" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $venus_zodiac_table; ?></text>
<text x="175" y="330" fill="white" transform="rotate(-90 175,330)" style="font-family:Verdana; font-size:12px"><?php echo $venus_arcminutes_table; ?></text>

<text x="225" y="80" fill="black" transform="rotate(-90 225,80)" style="font-family:Verdana; font-size:12px">Mars</text>
<text x="210" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mars_grad_table; ?></text>
<text x="210" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mars_zodiac_table; ?></text>
<text x="225" y="330" fill="white" transform="rotate(-90 225,330)" style="font-family:Verdana; font-size:12px"><?php echo $mars_arcminutes_table; ?></text>

<text x="275" y="80" fill="black" transform="rotate(-90 275,80)" style="font-family:Verdana; font-size:12px">Jupiter</text>
<text x="260" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $jupiter_grad_table; ?></text>
<text x="260" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $jupiter_zodiac_table; ?></text>
<text x="275" y="330" fill="white" transform="rotate(-90 275,330)" style="font-family:Verdana; font-size:12px"><?php echo $jupiter_arcminutes_table; ?></text>

<text x="325" y="80" fill="black" transform="rotate(-90 325,80)" style="font-family:Verdana; font-size:12px">Saturn</text>
<text x="310" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $saturn_grad_table; ?></text>
<text x="310" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $saturn_zodiac_table; ?></text>
<text x="325" y="330" fill="white" transform="rotate(-90 325,330)" style="font-family:Verdana; font-size:12px"><?php echo $saturn_arcminutes_table; ?></text>

<text x="375" y="80" fill="black" transform="rotate(-90 375,80)" style="font-family:Verdana; font-size:12px">Uranus</text>
<text x="360" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $uranus_grad_table; ?></text>
<text x="360" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $uranus_zodiac_table; ?></text>
<text x="375" y="330" fill="white" transform="rotate(-90 375,330)" style="font-family:Verdana; font-size:12px"><?php echo $uranus_arcminutes_table; ?></text>

<text x="425" y="80" fill="black" transform="rotate(-90 425,80)" style="font-family:Verdana; font-size:12px">Neptun</text>
<text x="410" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $neptun_grad_table; ?></text>
<text x="410" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $neptun_zodiac_table; ?></text>
<text x="425" y="330" fill="white" transform="rotate(-90 425,330)" style="font-family:Verdana; font-size:12px"><?php echo $neptun_arcminutes_table; ?></text>

<text x="475" y="80" fill="black" transform="rotate(-90 475,80)" style="font-family:Verdana; font-size:12px">Pluto</text>
<text x="460" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $pluto_grad_table; ?></text>
<text x="460" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $pluto_zodiac_table; ?></text>
<text x="475" y="330" fill="white" transform="rotate(-90 475,330)" style="font-family:Verdana; font-size:12px"><?php echo $pluto_arcminutes_table; ?></text>

<text x="525" y="80" fill="black" transform="rotate(-90 525,80)" style="font-family:Verdana; font-size:12px">Mondknoten</text>
<text x="510" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mondknoten_grad_table; ?></text>
<text x="510" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mondknoten_zodiac_table; ?></text>
<text x="525" y="330" fill="white" transform="rotate(-90 525,330)" style="font-family:Verdana; font-size:12px"><?php echo $mondknoten_arcminutes_table; ?></text>


<text x="575" y="80" fill="black" transform="rotate(-90 575,80)" style="font-family:Verdana; font-size:12px">Chiron</text>
<text x="560" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $chiron_grad_table; ?></text>
<text x="560" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $chiron_zodiac_table; ?></text>
<text x="575" y="330" fill="white" transform="rotate(-90 575,330)" style="font-family:Verdana; font-size:12px"><?php echo $chiron_arcminutes_table; ?></text>

<!-- Sonne -->
<circle cx="21" cy="125" r="12" stroke="black" stroke-width="1" fill="white" style="fill-opacity:0;" />
<circle cx="21" cy="125" r="1" stroke="black" stroke-width="1" fill="black" />

<!-- Mond -->
<path stroke="#000000" stroke-width="1" transform="translate (7,109) scale(0.16)" d="M372.778,26.284c-10.803,0-21.066,2.317-30.318,6.483
	c34.309,3.34,61.125,32.263,61.125,67.45c0,35.187-26.814,64.11-61.125,67.45c9.252,4.166,19.516,6.483,30.318,6.483
	c40.832,0,73.934-33.101,73.934-73.933C446.712,59.385,413.61,26.284,372.778,26.284z M372.778,167.989
	c-2.242,0-4.459-0.109-6.646-0.322c25.713-11.576,43.613-37.423,43.613-67.45c0-30.028-17.9-55.875-43.613-67.45
	c2.188-0.213,4.404-0.322,6.646-0.322c37.43,0,67.773,30.342,67.773,67.772C440.552,137.646,410.208,167.989,372.778,167.989z"/>

 
<!-- Merkur -->
<path stroke="#000000" stroke-width="1" transform="translate (110,70) scale(0.16)"  d="M107.451,344.188c0-18.152-11.215-33.683-27.093-40.046
	c8.767-3.513,16.112-9.821,20.933-17.822l-7.426,0.001c-6.746,8.952-17.468,14.74-29.541,14.74s-22.795-5.788-29.541-14.741h-7.426
	c4.82,8.001,12.166,14.309,20.933,17.822c-15.878,6.364-27.094,21.895-27.094,40.046c0,22.783,17.667,41.437,40.048,43.017v12.433
	H45.84v6.161h15.403v12.322h6.16v-12.322h15.403v-6.161H67.404v-12.433C89.785,385.625,107.451,366.971,107.451,344.188z
	 M64.324,381.154c-20.416,0-36.967-16.55-36.967-36.966s16.551-36.966,36.967-36.966s36.967,16.55,36.967,36.966
	S84.74,381.154,64.324,381.154z"/>


<!-- Venus -->
<path stroke="#000000" stroke-width="1" transform="translate (140,70) scale(0.16)" d="M233.583,344.188c0-23.819-19.309-43.127-43.117-43.127
	c-23.819,0-43.127,19.309-43.127,43.127c0,22.783,17.666,41.437,40.047,43.017v12.433h-15.402v6.161h15.402v12.322h6.157v-12.322
	h15.396v-6.161h-15.396v-12.433C215.917,385.625,233.583,366.971,233.583,344.188z M153.5,344.188
	c0-20.416,16.551-36.966,36.966-36.966c20.405,0,36.955,16.55,36.955,36.966s-16.55,36.966-36.955,36.966
	C170.051,381.154,153.5,364.604,153.5,344.188z"/>
	
<!-- Mars -->
<path stroke="#000000" stroke-width="1"  transform="translate (170,70) scale(0.16)" d="M359.221,289.73h-30.806v6.161h26.448l-15.699,15.7
	c-7.566-6.56-17.439-10.53-28.247-10.53c-23.828,0-43.136,19.309-43.136,43.127s19.308,43.127,43.136,43.127
	c23.826,0,43.135-19.309,43.135-43.127c0-10.801-3.97-20.674-10.531-28.24l15.7-15.7v26.449h6.16v-30.806v-6.161H359.221z
	 M310.917,381.154c-20.426,0-36.976-16.55-36.976-36.966s16.55-36.966,36.976-36.966c20.424,0,36.974,16.55,36.974,36.966
	S331.341,381.154,310.917,381.154z"/>

<!-- Jupiter -->
<path stroke="#000000" stroke-width="1" transform="translate (200,70) scale(0.16)" d="M490.131,381.156h-24.644v-0.001v-36.967h-6.161v36.967v0.001h-33.225H426.1
	c12.525-7.547,20.904-21.277,20.904-36.967c0-23.819-19.309-43.128-43.128-43.128v6.16c20.416,0,36.966,16.551,36.966,36.968
	c0,20.416-16.55,36.966-36.966,36.966v0.001v6.16l0,0h55.45v30.806h6.161v-30.806h24.644V381.156z"/>
	
<!-- Saturn -->	
<path stroke="#000000" stroke-width="1" transform="translate (230,70) scale(0.16)" d="M558.37,331.867c-7.834,0-15.182,2.089-21.514,5.74v-18.062h15.403v-6.161h-15.403
	v-12.322h-6.16v12.322h-15.402v6.161h15.402v30.938c6.771-7.641,16.661-12.456,27.674-12.456c20.416,0,36.967,16.551,36.967,36.967
	s-16.551,36.967-36.967,36.967v6.161c23.818,0,43.127-19.309,43.127-43.128C601.497,351.176,582.188,331.867,558.37,331.867z"/>

<!-- Mondknoten -->
<path stroke="#000000" stroke-width="1" transform="translate (460,-10) scale(0.16)" d="M413.332,887.015c12.137-10.172,19.857-25.443,19.857-42.519
		c0-30.624-24.826-55.45-55.451-55.45c-30.623,0-55.449,24.826-55.449,55.45c0,17.074,7.717,32.347,19.855,42.519
		c-7.887,2.109-13.695,9.305-13.695,17.856c0,10.208,8.275,18.483,18.484,18.483c10.207,0,18.482-8.275,18.482-18.483
		c0-7.181-4.098-13.399-10.08-16.46c-15.957-8.162-26.887-24.76-26.887-43.915c0-27.222,22.068-49.288,49.289-49.288
		s49.289,22.066,49.289,49.288c0,19.163-10.979,35.728-26.928,43.927c-5.963,3.066-10.043,9.281-10.043,16.448
		c0,10.208,8.275,18.483,18.482,18.483c10.209,0,18.484-8.275,18.484-18.483C427.023,896.32,421.217,889.126,413.332,887.015z
		 M346.934,892.549c6.805,0,12.322,5.517,12.322,12.322s-5.518,12.322-12.322,12.322s-12.322-5.517-12.322-12.322
		S340.129,892.549,346.934,892.549z M408.539,917.193c-6.805,0-12.322-5.517-12.322-12.322s5.518-12.322,12.322-12.322
		c6.807,0,12.322,5.517,12.322,12.322S415.346,917.193,408.539,917.193z"/>
	
<!-- Pluto -->	
<path stroke="#000000" stroke-width="1"  transform="translate (400,30) scale(0.16)"  d="M424.908,622.68h24.645c17.013,0,30.805-13.792,30.805-30.806
	s-13.792-30.805-30.805-30.805h-30.807v104.738h55.451v-6.161h-49.289V622.68z M424.908,567.229h24.645
	c13.609,0,24.644,11.034,24.644,24.645c0,13.611-11.034,24.645-24.644,24.645h-24.645V567.229z"/>
	
<!-- Chiron -->
<path stroke="#000000" stroke-width="1"  transform="translate (550,-10) scale(0.16)"  d="M110.533,861.896v-15.555l15.621,15.621l4.357-4.357l-17.426-17.426l17.426-17.426
	l-4.357-4.356l-15.621,15.621v-15.402h-6.162v43.28c-15.566,1.547-27.725,14.68-27.725,30.653c0,17.013,13.793,30.806,30.806,30.806
	c17.014,0,30.806-13.793,30.806-30.806C138.257,876.575,126.099,863.442,110.533,861.896z M107.452,917.192
	c-13.61,0-24.645-11.033-24.645-24.644s11.034-24.645,24.645-24.645s24.645,11.034,24.645,24.645S121.062,917.192,107.452,917.192z"
	/>
	
<!-- Uranus -->
<path stroke="#000000" stroke-width="1" transform="translate (343,30) scale(0.16)" d="M214.848,557.01v-6.479c-16.87,5.021-29.411,20.087-30.694,38.262H174.8v-33.887h-6.16
	v33.887h-9.353c-1.283-18.175-13.824-33.24-30.686-38.262l-0.003,6.479c14.351,5.074,24.638,18.768,24.638,34.863
	s-10.286,29.788-24.636,34.863l-0.001,6.479c16.862-5.021,29.404-20.087,30.688-38.262h9.353v34.144
	c-8.742,1.467-15.403,9.067-15.403,18.227c0,10.208,8.275,18.483,18.483,18.483s18.483-8.275,18.483-18.483
	c0-9.159-6.661-16.76-15.403-18.227v-34.144h9.354c1.283,18.175,13.824,33.24,30.693,38.262v-6.479
	c-14.357-5.076-24.643-18.768-24.643-34.863S200.489,562.085,214.848,557.01z M184.042,647.323c0,6.806-5.517,12.321-12.322,12.321
	s-12.322-5.516-12.322-12.321s5.517-12.322,12.322-12.322S184.042,640.518,184.042,647.323z"/>
	
<!-- Neptun -->
<path stroke="#000000" stroke-width="1" transform="translate (370,30) scale(0.16)" d="M350.672,567.229l-4.357,4.356l-8.713,8.713l4.357,4.356l5.631-5.632l-0.002,12.851
	c0,19.378-14.91,35.271-33.885,36.838v-74.333l5.633,5.632l4.355-4.356l-13.07-13.069l-4.359,4.356l-8.713,8.713l4.355,4.356
	l5.635-5.632v74.333c-18.977-1.566-33.887-17.46-33.887-36.838l-0.002-12.851l5.631,5.632l4.357-4.357l-13.07-13.067l-0.621,0.622
	L257.5,580.298l4.355,4.357l5.633-5.633l0.002,12.852c0,22.783,17.666,41.437,40.049,43.017v12.433h-15.404v6.162h15.404v12.321
	h6.164v-12.321h15.402v-6.162h-15.402v-12.433c22.381-1.579,40.047-20.233,40.047-43.017l0.002-12.852l5.633,5.633l4.357-4.356
	L350.672,567.229z"/>

</g>


</svg>
