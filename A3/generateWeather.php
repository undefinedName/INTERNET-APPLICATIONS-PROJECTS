<?php

$zip = $_GET["zip"];

$url = "http://api.openweathermap.org/data/2.5/weather?zip=$zip,us&units=imperial&appid=f2aa8984549bfb424df539a4baa3d209";

$fp = fopen ($url, "r");
$result = "";

while($more = fread ($fp, 1000)){
	$result .= $more;
}

echo "$result";
?>