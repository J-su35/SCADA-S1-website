<?php
// single line comment
# single line comment
/*
mutiline comment
	- Prefix $
	- Start with a letter or an underscore
	- Only letters, numbers and underscores
	- Case sensitive
*/

#Data type
/*
	-String
	-Intergers
	-floats
	-Booleans
	-Array
	-Objects
	-Null
	-Resource
*/

$output = 'Hello World!';
$_output = 'Hello World!';
echo "Hello World!";
// echo $output;  // wrong
echo $_output; //correct

$num1 =4;
$num2=10;
$sum = $num1 + $num2;

$string1 = 'Hello';
$string2 = 'World';
//เอา string ต่อกันต้องใช้ .
$greeting1=$string1 . $string2.'!';  
$greeting2=$string1 .' '.$string2.'!';
$greeting3='$string1 $string2';  //$string1 $string2
$greeting4="$string1 $string2";  //Hello World

$string5 = 'They\'re Here'; //กรณี single quote '' string ภาษาอังกฤษมี apostrophe 's ให้ใช้ \ ช่วย ไม่งั้น error วิธีที่ดีที่สุดคือเสี่ยงไปใช้ Double quote
$string6 = "They're Here";



$float = 4.4;
$bool1 =true;

define('GREETING', 'Hello Everyone');

echo $string5;

echo GREETING;  //Hello Everyone

?>