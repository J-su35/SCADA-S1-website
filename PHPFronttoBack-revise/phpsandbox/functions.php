<?php

# Function - Block of code that can be repeatedly called

/*

Camel Case - myFunction()
Lower Case - my_function()
Pascal Case - myFunction()
*/

# Create simple function
function simpleFunction() {
	echo 'Hello World';
}

//Run simple function
simpleFunction();

//Function With Param
function sayHello($name) {
	echo "Hello $name<br>";
}

sayHello('Joe');
sayHello('Brad');

// function return
// กรณีไม่มี return จะแสดงค่าเลย
function addNumbers($num1, $num2) {
	echo $num1 + $num2;
}

addNumbers(5,4);

//กรณีมี return จะเก็บค่าในรูปตัวแปรไม่แสดงค่า/ต้องมีตัวแปรมารับค่า
function addNumbersReturn($num1, $num2) {
	return $num1 + $num2;
}

echo addNumbersReturn(5,4);

echo "<br>";

// By Reference
$myNum = 10;

function addFive($num) {
	$num += 5;
}

function addTen(&$num) {
	$num +=10;
}

addFive($myNum);
echo "Value : $myNum<br>";


addTen($myNum);
echo "Value : $myNum<br>";



?>