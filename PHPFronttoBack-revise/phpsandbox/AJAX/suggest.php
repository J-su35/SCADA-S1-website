<?php
//People Array @TODO - Get from DB
$people[] = "Steve";
$people[] = "Smith";
$people[] = "Alice";
$people[] = "Alex";
$people[] = "Bill";
$people[] = "Brown";
$people[] = "Cathy";
$people[] = "Catherine";
$people[] = "David";
$people[] = "Dave";

//Get Query String
$q = $_REQUEST['q'];

$suggestion = "";

//Get suggestion
if($q !== ""){
	$q = strtolower($q);
	$len = strlen($q);
	foreach($people as $person){
		if(stristr($q, substr($person, 0, $len))){
			if($suggestion === ""){
				$suggestion = $person;
			} else {
				$suggestion .= ", $person";
			}
		}
	}
}

echo $suggestion === "" ? "No Suggestion" : $suggestion;
?>