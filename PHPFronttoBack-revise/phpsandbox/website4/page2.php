<?php
	setcookie('username', 'Frank', time() + (86400 * 30));

	// Delate Cookie
	// setcookie('username', 'Frank', time() - 3600);

	if(count($_COOKIE) > 0){
		echo 'There\'re '.count($_COOKIE). ' cookies saved<br>';
	} else {
		echo 'There are no cookies saved<br>';
	}

if(isset($_COOKIE['username'])){
	echo 'User ' . $_COOKIE['username'] . 'is set <br>';

} else {
	echo 'User is not set';
}