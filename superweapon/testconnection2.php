<?php

// Configuration Settings for connection to Database
$host = 'S172.30.203.154'; //serverName\instanceName, portNumber (default is 1433)
$user = 'opds1';
$pass = '10514A#983*b';
$db   = 'SCADA';
$conn = "DRIVER={ODBC Driver 17 for SQL Server};SERVER=$host;PORT=1433;DATABASE=$db";

// Open connection
$db_connect = odbc_connect($conn, $user, $pass);

// Check for successful connection
if ( $db_connect ) {
    echo "Connection established.<br />";
} else {
  echo "Connection could not be established.<br />";
  die( print_r( sqlsrv_errors(), true));
}

?>
