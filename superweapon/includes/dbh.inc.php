<?php

$serverName = "172.30.203.154, 1433"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array( "Database"=>"SCADA", "UID"=>"opds1", "PWD"=>"10514A#983*b");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if (!$conn) {
  echo "Connection could not be established.<br />";
  die( print_r( sqlsrv_errors(), true));ie("Connection failed: ".mysqli_connect_error());
}

// if( $conn ) {
//      echo "Connection established.<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }

?>
