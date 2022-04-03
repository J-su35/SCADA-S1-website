<?php
	// $path = '/dirt/myfile.php';
	$path = '/phpsandbox/File System Functions';
	$file1 = 'file1.txt';

	//Return filename
	// echo basename($path);

	// Return filename withput ext
	// echo basename($path, '.php');

	//Return th dir name from path
	// echo dirname($path);

	//Check if file exists
	// echo file_exists($file1);  //1

	//Get abs path
	// echo realpath($file1);

	//Checks to see if file
	// echo is_file($file1);  //1

	//Checks if writable
	// echo is_writeable($file1); //1

	//Checks if readable
	// echo is_readable($file1);  //1


	//Get filesize
	// echo filesize($file1);

	//Create a directory
	// mkdir('testing');

	//Remove dir if empty
	// rmdir('testing');

	//Copy file
	// echo copy('file1.txt', 'file2.txt');

	//Rename File
	// rename('file2.txt', 'myfile.txt');

	// Delete File 
	// unllik('myfile.txt');

	//Write from file to string
	// echo file_get_contents($file1);

	//Write string to file
	// echo file_put_contents($file1, 'Hello test');

	// $current = file_get_contents($file1);

	// $current .= ' Goodbye';

	// file_put_contents($file1, $current);

	//Open File For Reading
	// $handle = fopen($file1, 'r');
	// $data = fread($handle, filesize($file1));
	// echo $data;

	//Open file for writing
	$handle = fopen('file2.txt', 'w');
	$txt = "Jonh Doe\n";
	fwrite($handle, $txt);
	$txt = "Steve Smith";
	fwrite($handle, $txt);
	fclose($handle);







?>