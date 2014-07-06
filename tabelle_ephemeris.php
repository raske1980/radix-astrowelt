<?php
$content="Content-type: image/svg+xml";
header($content);
echo '<?xml version="1.0" ?>';


$datum = date("d.m.Y");

$link = "http://neu.webnagel.de/astro-xml/test/planets.php?birthdate=" . $datum . "&long=10.416667&lat=51.133333&ut=4:00";

$xml = simplexml_load_file($link);
$birthdate = $xml->metadata->birthdate;
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



?> 
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="600" height="360">
<title>Ephemeris</title> 
<desc>Aktuelle Planetenpositionen</desc> 





<rect x="0" y="100" width="600" height="235" style="stroke: #000; fill:none;" />
<rect x="0" y="100" width="600" height="50" style="stroke: #000; fill:#fff;" />
<rect x="0" y="150" width="600" height="50" style="stroke: #000; fill:#68c1ec;" />
<rect x="0" y="200" width="600" height="50" style="stroke: #000; fill:#fc9a00;" />
<rect x="0" y="247" width="600" height="90" style="stroke: #000; fill:#215fa3;" />
<line x1="0" y1="150" x2="600" y2="150" style="stroke:black;stroke-width:1" />
<line x1="0" y1="200" x2="600" y2="200" style="stroke:black;stroke-width:1" />



<text x="359" y="350" fill="black" style="font-family:Verdana; font-size:12px"><?php echo "Datenermittlung: " . $birthdate . ", 6:00 Uhr"; ?></text>

<text x="25" y="80" fill="black" transform="rotate(-90 25,80)" style="font-family:Verdana; font-size:12px">Sonne</text>
<text x="10" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $sonne_grad; ?></text>
<text x="10" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $sonne_zodiac; ?></text>
<text x="25" y="330" fill="white" transform="rotate(-90 25,330)" style="font-family:Verdana; font-size:12px;"><?php echo $sonne_arcminutes; ?></text>


<text x="75" y="80" fill="black" transform="rotate(-90 75,80)" style="font-family:Verdana; font-size:12px">Mond</text>
<text x="60" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mond_grad; ?></text>
<text x="60" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mond_zodiac; ?></text>
<text x="75" y="330" fill="white" transform="rotate(-90 75,330)" style="font-family:Verdana; font-size:12px"><?php echo $mond_arcminutes; ?></text>

<text x="125" y="80" fill="black" transform="rotate(-90 125,80)" style="font-family:Verdana; font-size:12px">Merkur</text>
<text x="110" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $merkur_grad; ?></text>
<text x="110" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $merkur_zodiac; ?></text>
<text x="125" y="330" fill="white" transform="rotate(-90 125,330)" style="font-family:Verdana; font-size:12px"><?php echo $merkur_arcminutes; ?></text>

<text x="175" y="80" fill="black" transform="rotate(-90 175,80)" style="font-family:Verdana; font-size:12px">Venus</text>
<text x="160" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $venus_grad; ?></text>
<text x="160" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $venus_zodiac; ?></text>
<text x="175" y="330" fill="white" transform="rotate(-90 175,330)" style="font-family:Verdana; font-size:12px"><?php echo $venus_arcminutes; ?></text>

<text x="225" y="80" fill="black" transform="rotate(-90 225,80)" style="font-family:Verdana; font-size:12px">Mars</text>
<text x="210" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mars_grad; ?></text>
<text x="210" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mars_zodiac; ?></text>
<text x="225" y="330" fill="white" transform="rotate(-90 225,330)" style="font-family:Verdana; font-size:12px"><?php echo $mars_arcminutes; ?></text>

<text x="275" y="80" fill="black" transform="rotate(-90 275,80)" style="font-family:Verdana; font-size:12px">Jupiter</text>
<text x="260" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $jupiter_grad; ?></text>
<text x="260" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $jupiter_zodiac; ?></text>
<text x="275" y="330" fill="white" transform="rotate(-90 275,330)" style="font-family:Verdana; font-size:12px"><?php echo $jupiter_arcminutes; ?></text>

<text x="325" y="80" fill="black" transform="rotate(-90 325,80)" style="font-family:Verdana; font-size:12px">Saturn</text>
<text x="310" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $saturn_grad; ?></text>
<text x="310" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $saturn_zodiac; ?></text>
<text x="325" y="330" fill="white" transform="rotate(-90 325,330)" style="font-family:Verdana; font-size:12px"><?php echo $saturn_arcminutes; ?></text>

<text x="375" y="80" fill="black" transform="rotate(-90 375,80)" style="font-family:Verdana; font-size:12px">Uranus</text>
<text x="360" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $uranus_grad; ?></text>
<text x="360" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $uranus_zodiac; ?></text>
<text x="375" y="330" fill="white" transform="rotate(-90 375,330)" style="font-family:Verdana; font-size:12px"><?php echo $uranus_arcminutes; ?></text>

<text x="425" y="80" fill="black" transform="rotate(-90 425,80)" style="font-family:Verdana; font-size:12px">Neptun</text>
<text x="410" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $neptun_grad; ?></text>
<text x="410" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $neptun_zodiac; ?></text>
<text x="425" y="330" fill="white" transform="rotate(-90 425,330)" style="font-family:Verdana; font-size:12px"><?php echo $neptun_arcminutes; ?></text>

<text x="475" y="80" fill="black" transform="rotate(-90 475,80)" style="font-family:Verdana; font-size:12px">Pluto</text>
<text x="460" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $pluto_grad; ?></text>
<text x="460" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $pluto_zodiac; ?></text>
<text x="475" y="330" fill="white" transform="rotate(-90 475,330)" style="font-family:Verdana; font-size:12px"><?php echo $pluto_arcminutes; ?></text>

<text x="525" y="80" fill="black" transform="rotate(-90 525,80)" style="font-family:Verdana; font-size:12px">Mondknoten</text>
<text x="510" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mondknoten_grad; ?></text>
<text x="510" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $mondknoten_zodiac; ?></text>
<text x="525" y="330" fill="white" transform="rotate(-90 525,330)" style="font-family:Verdana; font-size:12px"><?php echo $mondknoten_arcminutes; ?></text>


<text x="575" y="80" fill="black" transform="rotate(-90 575,80)" style="font-family:Verdana; font-size:12px">Chiron</text>
<text x="560" y="180" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $chiron_grad; ?></text>
<text x="560" y="230" fill="black" style="font-family:Verdana; font-size:12px"><?php echo $chiron_zodiac; ?></text>
<text x="575" y="330" fill="white" transform="rotate(-90 575,330)" style="font-family:Verdana; font-size:12px"><?php echo $chiron_arcminutes; ?></text>

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
	
	

	
	
	

</svg>