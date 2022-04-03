<?php
# Conditionals

/*
==
===
<
>
<=
>=
!=
!==
*/

$num = 5;

$num2 = 52;

if($num == 5) {
	echo '5 passed ==<br>';
}

if($num === 5) {
	echo '5 passed ===<br>';
}

if($num > 5) {
	echo '5 passed > <br>';
}

if($num >= 5) {
	echo '5 passed >= <br>';
}

if($num2 != 5) {
	echo '5 passed != <br>';
}

if($num2 == 5) {
	echo '5 passed ==<br>';
} else {
	echo "Did not pass<br>";
}

if($num2 == 5) {
	echo '5 passed ==<br>';
} elseif ($num2 == 52) {
	echo "52 passed<br>";
} else {
	echo "Did not pass<br>";
}

// Nesting if
$num3 = 6;

if($num3 > 5) {
	if($num3 > 4) {
		if($num3 < 10) {
		echo "$num passed<br>";
		}
	}
}

// Logical operators
/*
and &&
OR ||
XOR
*/

if ($num > 4 && $num <10) {
	echo "$num passed<br>";
}

if ($num > 4 OR $num <10) {
	echo "$num passed<br>";
}

if ($num > 4 XOR $num <10) {
	echo "$num passed<br>";
}


//-----------------------------------------------------
# Switch

$favColor = 'red';

switch ($favColor) {
	case 'red':
		echo 'Your favorite color is red';
		break;
	
	case 'blue':
		echo 'Your favorite color is blue';
		break;

	case 'green':
		echo 'Your favorite color is green';
		break;

	default :
		echo 'Your favorite color is something else';
		break;
}	

?>