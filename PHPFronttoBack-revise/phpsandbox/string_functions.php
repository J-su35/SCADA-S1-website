<?php
	# substr()
	# Returns a portion of string

	$output = substr('Hello', 1);
	echo $output;

	$output2 = substr('Hello', 1, 3);
	echo $output2;

	$output3 = substr('Hello', -2);
	echo $output3;

	#strlen()
	# Returns the length of a string

	$output4 = strlen('Hello World');
	echo $output4;

	# strpos()
	# Finds the position of first occurence of a substring

	$output5 = strpos('Hello World', 'o');
	echo $output5;	

	# strrpos()
	# Finds the position of last occurence of a substring

	$output5 = strpos('Hello World', 'o');
	echo $output5;	

	# trim()
	# Strips whitespace

	$text = 'Hello World';
	var_dump($text);

	$trimmed = trim($text);
	var_dump($trimmed);

	# strtoupper
	# Make everything uppercase

	$output6 = strtoupper('Hello World');
	echo $output6;

	# strtolower
	# Make everything lowercase

	$output7 = strtolower('Hello World');
	echo $output7;

	# ucwords()
	$output8 = ucwords('hello world');
	echo $output8;

	# str_replace()
	# Replace all occurances of a search string with a replacement

	$text = 'Hello World';
	$output9 = str_replace('World', 'Everyone', $text);
	echo $output9;

	# is_string()
	# Check if string

	$val = '22';
	$output10 = is_string($val);
	echo $output10;

	$values = array(true, false, null, 'abc', 33, '33', 22.4, '22.4','',' ', 0, '0');

	foreach ($values as $value) {
		if(is_string($value)) {
			echo "{value} is a string<br>";
		}
	}

	$string = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sit amet metus ut odio laoreet viverra in ut augue. Nam ut ante iaculis, egestas nibh non, ultricies leo. Morbi et molestie odio, ut viverra magna. Phasellus sit amet nulla diam. Morbi et sem commodo, gravida mi ut, tempor dui. Suspendisse id sapien egestas mi posuere venenatis nec eget massa. Praesent volutpat urna ex, ornare varius libero lacinia non. Quisque maximus sit amet tellus et viverra. Donec consectetur ultrices sem a feugiat. Nullam blandit lacinia dignissim. Donec vel accumsan odio.";

	$compressed = gzcompress($string);
	echo $compressed;

	$orginal = gzuncompress($compressed);
	echo $orginal;

?>