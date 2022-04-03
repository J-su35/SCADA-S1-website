<?php
/*$con = mysqli_connect("localhost","root","","load01");
if (mysqli_connect_errno($con))
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/
$devMode = false;

$ServerName_mysql = "";
$UserName_mysql = "";
$UserPassword_mysql = "";
$DataBaseName_mysql = "";

if($devMode){
	$ServerName_mysql = "localhost";
	$UserName_mysql = "root";
	$UserPassword_mysql = "";
	$DataBaseName_mysql = "southload";
}
else{
	$ServerName_mysql = "localhost";
	$UserName_mysql = "dms";
	$UserPassword_mysql = "dms_2014";
	$DataBaseName_mysql = "dms";
}

$ServerName_mssql = "172.29.84.96";
$UserName_mssql = "smc";
$UserPassword_mssql = "1qaz@WSX";
$DataBaseName_mssql = "SCADA";


$ftp_user = array("C1"=>"ecs","C2"=>"ecs","C3"=>"ecs","S1"=>"ecs","N3"=>"ecs");
$ftp_pass = array("C1"=>"addcc1","C2"=>"1point","C3"=>"gotoECS3","S1"=>"Ecsecs","N3"=>"Eagle");
$ftp_server = array("C1"=>"10.102.40.25","C2"=>"pc2sys","C3"=>"pc3sys","S1"=>"ps1sys","N3"=>"pn3sys");
?>