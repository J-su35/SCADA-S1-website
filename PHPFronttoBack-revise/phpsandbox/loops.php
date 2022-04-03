<?php
# Loops - Execute code set number of times

/*
For
While
Do..While
Foreach
*/

#For loop
# @params - init, condition, inc

// for($i = 0; $i < 10 ;$i++) {
// 	echo 'Number '.$i;
// 	echo '<br>';
// }
//------------------------------------

#While loop
# @params - condition

// $i = 0;
// while($i<10) {
// 	echo $i;
// 	echo '<br>';
// 	$i++;
// }

//------------------------------------

# Do..while
# @params - condition

// $i = 0;
// do {
// 	echo $i;
// 	echo '<br>';
// 	$i++;
// }

// while($i < 10);

//------------------------------------
# Foreach
// $people = array('Brad', 'Jose', 'William');

// foreach ($people as $person) {
// 	echo $person;
// 	echo '<br>';
// }

//------------------------------------

$people2 = array('Brad' => 'brad@gmail.com', 'Jose' => 'Jose@gmail.com', 'William' => 'William@gmail.com');

foreach ($people2 as $person => $email) {
	echo $person.': '.$email;
	echo '<br>';
}




?>