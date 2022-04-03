<?php

echo date('d');  //Day
echo "<br>";

echo date('m');  //Month
echo "<br>";

echo date('Y'); //Year
echo "<br>";

echo date('l'); //Week
echo "<br>";

echo date('Y/m/d');
echo "<br>";

echo date('m-d-Y');
echo "<br>";

echo date('h'); //hour
echo "<br>";

echo date('i'); //Min
echo "<br>";

echo date('s'); //Seconds
echo "<br>";

echo date('a'); // AM or PM
echo "<br>";

//Set Time Zone

// date_default_timezone_set('America/New_York');

echo date('h:i:sa');
echo "<br>";

$timestamp = mktime(10, 14, 54, 9, 10, 1981);

echo $timestamp;
echo "<br>";

echo date('m/d/Y', $timestamp);
echo date('m/d/Y h:i:sa', $timestamp);
echo "<br>";

$timestamp2 = strtotime('7:00pm March 22 2016');
echo $timestamp2;
echo date('m/d/Y h:i:sa', $timestamp2);
echo "<br>";

$timestamp3 = strtotime('tomorow');
echo date('m/d/Y h:i:sa', $timestamp3);
echo "<br>";

$timestamp4 = strtotime('next Sunday'); 
echo date('m/d/Y h:i:sa', $timestamp4);
echo "<br>";

$timestamp5 = strtotime('+2 Month'); 
echo date('m/d/Y h:i:sa', $timestamp5);
echo "<br>";

//learn more at php.net/manual/en/function.date.php
?>