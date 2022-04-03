<?php
	// Check for post data
	if(filter_has_var(INPUT_POST, 'data')) {
		echo 'Data Found';		
	} else {
		echo 'No Data';
	}

	if(filter_has_var(INPUT_POST, 'data')){
		$email = $_POST['data'];

		// Remove illegal chars
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		echo $email.'<br>';

		// if(filter_input(INPUT_POST, 'data', FILTER_VALIDATE_EMAIL)) {
		// 	echo "Email is valid";
		// } else {
		// 	echo "Email is not valid";
		// }

		if(filter_input($email, FILTER_VALIDATE_EMAIL)) {
			echo "Email is valid";
		} else {
			echo "Email is not valid";
		}
	}

	#FILTER_VALIDATE_BOLEAN
	#FILTER_VALIDATE_EMAIL
	#FILTER_VALIDATE_FLOAT
	#FILTER_VALIDATE_INT
	#FILTER_VALIDATE_IP
	#FILTER_VALIDATE_REGEXP
	#FILTER_VALIDATE_URL

	#FILTER_SANITIZE_BOLEAN
	#FILTER_SANITIZE_EMAIL
	#FILTER_SANITIZE_FLOAT
	#FILTER_SANITIZE_INT
	#FILTER_SANITIZE_IP
	#FILTER_SANITIZE_REGEXP
	#FILTER_SANITIZE_URL

// ---------------------------------------------------------------------------

	$var = 23;

	if(filter_var($var, FILTER_VALIDATE_INT)){
		echo $var. ' is a number';
	} else {
		echo $var. ' is not a number';
	}

	$number = '33k2jj32k3232j3j2k3j';
	var_dump(filter_var($number, FILTER_SANITIZE_NUMBER_INT));

	$var1 = '<script>alert(1)</script>';
	echo filter_var($var1, FILTER_SANITIZE_SPECIAL_CHARS);

	$filters = array(
		"data" => FILTER_VALIDATE_EMAIL,
		"data2" => array(
			"filter" => FILTER_VALIDATE_INT,
			"options" => array(
				"min_range" => 1,
				"max_range" => 100
			)
		)
	);

	print_r(filter_input_array(INPUT_POST, $filters));

	$arr = array(
		"name" => "brad traversy",
		"age" => "35",
		"email" => "brad@gmail.com"
	);

	$filters1 = array(
		"name" => array(
			"filter" => FILTER_CALLBACK,
			 "options" => "ucwords"
			),
		"age" => array(
			"filter" => FILTER_VALIDATE_INT,
			"options" => array(
				"min_range" => 1,
				"max_range" => 120
			)
		),
		"email" => FILTER_VALIDATE_EMAIL
	);

	print_r(filter_var_array($arr, $filters1))

?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="data">
	<button type="submit">Submit</button>
</form>

<!-- ------------------------------------------------------------------- -->

<!-- <?php
	// Check for get data
	//if(filter_has_var(INPUT_GETT, 'data')) {
	//	echo 'Data Found';		
	//} else {
	//	echo 'No Data';
	//}
?>

//<form method="get" action="<?php //echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="data">
	<button type="submit">Submit</button>
</form> -->

<!-- ------------------------------------------------------------------- -->