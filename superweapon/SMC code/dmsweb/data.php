<?php
// $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");
// $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
$DATABASE_SERVER_IP = "172.29.84.15";
$DATABASE_SERVER_IP = "172.30.203.154";
if(isset($_GET['server'])){
  if($_GET['server'] == '154'){
      $DATABASE_SERVER_IP = "172.30.203.154";
  }
  else if($_GET['server'] == '15'){
      $DATABASE_SERVER_IP = "172.29.84.15";
  }
}

function get_year_from_date($date){
    return substr($date,0,4);
}

if ($_GET['mode'] == 'province') {
    $data = get_load_data_province($_GET['date'], $_GET['area'], $_GET['province']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == '14') {
    $data = get_load_data_14province($_GET['date']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == '1') {
    $data = get_load_data_1province($_GET['date'], $_GET['pvid']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == '14total') {
    $data = get_load_data_14province_total($_GET['date']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'spp-vspp') {
    $data = get_load_data_spp_vspp($_GET['date'], $_GET['area']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'spp-vspp-type') {
    $data = get_load_data_spp_vspp_type($_GET['date'], $_GET['area']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'feeder') {
    $data = get_load_data_feeder($_GET['date'], $_GET['area'], $_GET['substation']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'feeder_monthly') {
    $data = get_load_data_feeder_monthly($_GET['date'], $_GET['datestop'], $_GET['area'], $_GET['substation']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'tp_overview') {
    $data = get_load_data_tp_daily($_GET['date'], $_GET['datestop']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'tp_daily') {
    $data = get_load_data_tp_daily($_GET['date'], $_GET['area'], $_GET['substation']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'tp_monthly') {
    $data = get_load_data_tp_monthly($_GET['date'], $_GET['datestop'], $_GET['area'], $_GET['substation']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'tp_daily_m') {
    $data = get_load_data_tp_daily_m($_GET['date'], $_GET['datestop'], $_GET['area'], $_GET['substation']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'spp-vspp-province') {
    $data = get_load_data_spp_vspp_province($_GET['date'], $_GET['area'], $_GET['sppvspp'], $_GET['province'], $_GET['hvmv'], $_GET['type']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'spp-vspp-new') {
    $data = get_data_vspp_profile_area($_GET['date'], $_GET['area']);
} else if ($_GET['mode'] == 'spp-vspp-province-beta') {
    $data = get_load_data_spp_vspp_province($_GET['date'], $_GET['area'], $_GET['sppvspp'], $_GET['province'], $_GET['hvmv'], $_GET['type']);
    print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'province_monthly') {
      $data = get_load_data_province_monthly($_GET['date'], $_GET['datestop'], $_GET['area'], $_GET['province']);
      print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'weekload') {
      $data = get_load_data_weekload($_GET['date']);
      print json_encode($data, JSON_NUMERIC_CHECK);
} else if ($_GET['mode'] == 'daily_peak_load') {
      $data = get_load_data_daily_peak_load($_GET['date1'], $_GET['date2'], $_GET['match_option']);
      print json_encode($data, JSON_NUMERIC_CHECK);
} else {
    $data = get_load_data_1day($_GET['date'], $_GET['province']);
    print json_encode($data, JSON_NUMERIC_CHECK);
}

function get_load_data_daily_peak_load($day1, $day2, $match_option)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $dataMin = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day1 = date_create_from_format("d-m-Y", $day1)->getTimestamp();
    $day2 = date_create_from_format("d-m-Y", $day2)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day1);
    $yearAgo = ((int)date("Y", $day1))-1;
    $start_date = date("Y-m-d", $day1);
    $last_date = date("Y-m-d", $day2);
    $start_dateAgo = $yearAgo.substr($start_date, 4);
    $last_dateAgo = $yearAgo.substr($last_date, 4);
    //$last_time = date("H:i", $day1);
    $last_time = "00:00";
    if($match_option == 'match_dow'){
      $dayOfWeekDiff = date('w', strtotime($start_date)) - date('w', strtotime($start_dateAgo));
      $dateTmp = new DateTime($start_dateAgo);
      if(7-abs($dayOfWeekDiff) < abs($dayOfWeekDiff)){
        if($dayOfWeekDiff < 0){
          date_add($dateTmp, date_interval_create_from_date_string((7-abs($dayOfWeekDiff)).' days'));
        }
        else{
          date_sub($dateTmp, date_interval_create_from_date_string((7-$dayOfWeekDiff).' days'));
        }
      }
      else{
        if($dayOfWeekDiff < 0){
          date_sub($dateTmp, date_interval_create_from_date_string(abs($dayOfWeekDiff).' days'));
        }
        else{
          date_add($dateTmp, date_interval_create_from_date_string($dayOfWeekDiff.' days'));
        }
      }
      $start_dateAgo = date_format($dateTmp, 'Y-m-d');
      $output['startDateAgo'] = date_format($dateTmp, 'D').' '.date_format($dateTmp, 'd-m-Y');
      date_add($dateTmp, date_diff(new DateTime($start_date), new DateTime($last_date)));
      $last_dateAgo = $dateTmp->format('Y-m-d');
      $output['lastDateAgo'] = date_format($dateTmp, 'D').' '.date_format($dateTmp, 'd-m-Y');;
    }


    $query = "SELECT [date], Sub, Bay, MAX(mw) mw
      FROM
      (SELECT [date],[time], '$year' AS Sub,'$year' AS Bay, SUM(subload) as mw
      FROM LOAD_$year
      WHERE feeder = 'PROVINCE'
      AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
      AND date >= '$start_date' AND date <= '$last_date'
      GROUP BY [date],[time]) profile
      GROUP BY profile.[date], Sub, Bay
      ORDER BY [date]";

    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    $output['name'] = array();

    while ($row = mssql_fetch_object($result)) {
        if (!in_array($row->Bay, $output['name'])) {
            array_push($output['name'], $row->Bay);
        }
        $data2[$row->Bay][$row->date] = $row->mw;
    }

    $output["categories"] = array();
    while (strtotime($start_date) <= strtotime($last_date)) {
        array_push($output["categories"], substr($start_date,8,2).'-'.substr($start_date,5,2));
        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
    }

    foreach ($data2 as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }
    }

    mssql_free_result($result);
    $data2 = array();

    $query = "SELECT [date], Sub, Bay, MAX(mw) mw
      FROM
      (SELECT [date],[time], '$yearAgo' AS Sub,'$yearAgo' AS Bay, SUM(subload) as mw
      FROM LOAD_$yearAgo
      WHERE feeder = 'PROVINCE'
      AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
      AND date >= '$start_dateAgo' AND date <= '$last_dateAgo'
      GROUP BY [date],[time]) profile
      GROUP BY profile.[date], Sub, Bay
      ORDER BY [date]";

    ini_set('max_execution_time', 60);
    $result = mssql_query($query);

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    while ($row = mssql_fetch_object($result)) {
        if (!in_array($row->Bay, $output['name'])) {
            array_push($output['name'], $row->Bay);
        }
        $data2[$row->Bay][$row->date] = $row->mw;
    }

    foreach ($data2 as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }
    }

    $nameArr = array();
    $labelArr = array();

    mssql_free_result($result);
    mssql_close($conn);

    return $output;
}

function get_load_data_weekload($day){
  include "db_connection.php";

  $data = array();
  $timestamp = array();
  $total_mw = array();
  $category = array();
  $output = array();
  $subInProvince = array();

  //$conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
  $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

  if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
      die("Cannot connect or select SQL Server database (data.php)");
  }

  //$day = strtotime($day);
  $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
  //$midnight = strtotime("today midnight");
  $last_date = date("Y-m-d", $day);
  //$last_time = date("H:i", $day);
  $last_time = "00:00";
  $year = date("Y", $day);
  $prev_year = date("Y", $day) - 1;
  $yesterday = date("Y-m-d", $day - (60 * 60 * 24));
  $start_date = date("Y-m-d", $day - 6*(60 * 60 * 24));
  $start_year = date("Y", $day - 6*(60 * 60 * 24));

  $output['startday'] = date("w", $day + (60 * 60 * 24));

  $query = "";

  $output['12Area'] = 0;

  $query = "SELECT [date],[time],'Total' AS Sub ,'Total' AS Bay , SUM(subload) as mw
      FROM SCADA.dbo.LOAD_$year
      WHERE feeder = 'PROVINCE'
      AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
      AND date >= '$start_date' AND date <= '$last_date'
      GROUP BY [date],[time]
      ORDER BY [date],[time] ASC";
  $output['12Area'] = 1;
  //echo $query;

  /*$query = sprintf("SELECT date, time, 'Total' AS Sub, 'Total' AS Bay, SUM(Load) AS mw
      FROM Bay_Load
      WHERE Sub IN ('%s_SPPHV', '%s_SPPMV', '%s_VSPPHV', '%s_VSPPMV')
      AND Bay IN ('GAS','BIO','COAL','HYDRO','OIL','OTHER','SOLAR','WASTE','WIND')
      AND date = '$last_date' AND time >= '$last_time'
      GROUP BY date, time",$area,$area,$area,$area);*/

  ini_set('max_execution_time', 120);
  ini_set('mssql.connect_timeout', 120);
  ini_set('mssql.timeout', 120);
  set_time_limit (120);
  $result = mssql_query($query);
  //print $query.'</br>';

  if ($result === false) {
      die("Error sending query to SQL Server database.<br/>");
  }

  if (mssql_num_rows($result) <= 0) {
      $output['available'] = 1;
  } else {
      $output['available'] = 0;
  }

  $total = 0;
  $lastDatetime = '';

  $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

  $nameArr = array();
  $labelArr = array();
  while ($row = mssql_fetch_object($result)) {
      if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
          $datetime = "$row->date $row->time";
          if(!in_array($row->date, $nameArr)){
            array_push($nameArr, $row->date);
            array_push($labelArr, $row->date);
          }
          $data[$row->Bay][$datetime] = $row->mw;
          // $data2[$row->Bay][$row->time] = $row->mw;
          $data2[$row->date][$row->time] = $row->mw;
          $PeakDate[$row->Bay] = $row->date;

          if (in_array($datetime, $category) === false) {
              $category[] = $datetime;
          }
      }
  }

  mssql_free_result($result);

  $catIdx = 0;
  foreach ($data2 as $sub => $item) {
      foreach ($output["categories"] as $key => $time) {
          if (array_key_exists($time, $item)) {
              $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
          } else {
              $output['values'][$sub][] = null;
          }
      }
  }

  mssql_close($conn);
//    mysqli_close($dbc);

  $output['name'] = $nameArr;
  $output['label'] = $labelArr;

  return $output;
}

function get_data_vspp_profile_area($day, $area)
{
    include "db_connection.php";

    if (is_null($province)) {
        $province = 'Total';
    }

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    // $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");
    // $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
    $conn = mssql_connect($GLOBALS['DATABASE_SERVER_IP'], "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day);
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "";
    $query_tmp = "";
    $query1 = "";
    $query2 = "";
    $query3 = "";

    $output['12Area'] = 0;

    //Lookup Table
    $area2Code = array("N1" => "11", "N2" => "12", "N3" => "13", "NE1" => "21", "NE2" => "22", "NE3" => "23", "C1" => "31", "C2" => "32", "C3" => "33", "S1" => "41", "S2" => "42", "S3" => "43");

    if ($area == "Total") {
        $query1 = "SELECT date, time, 'Total' AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query2 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time
              UNION
              SELECT date, time, LEFT(substation,2) AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query3 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time, LEFT(substation,2)
              ORDER BY Bay, date, time";
        if ($sppvspp == "Total") {
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = "
						WHERE (Substation = '11SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'
 						    OR Substation = '12SH' OR Substation = '12SM' OR Substation = '12VH' OR Substation = '12VM'
 						    OR Substation = '13SH' OR Substation = '13SM' OR Substation = '13VH' OR Substation = '13VM'
 						    OR Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'
						    OR Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'
						    OR Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'
						    OR Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'
						    OR Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'
						    OR Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'
					        OR Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'
						    OR Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'
					        OR Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM')";
                            //$output['12Area'] = 1;
                    } else { // $type
                        $query_tmp = "
						WHERE (Substation = '11SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'
 						    OR Substation = '12SH' OR Substation = '12SM' OR Substation = '12VH' OR Substation = '12VM'
 						    OR Substation = '13SH' OR Substation = '13SM' OR Substation = '13VH' OR Substation = '13VM'
 						    OR Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'
						    OR Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'
						    OR Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'
						    OR Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'
						    OR Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'
						    OR Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'
					        OR Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'
						    OR Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'
					        OR Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM')
							AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = "
						 WHERE (Substation = '11S" . $hvmv . "' OR Substation = '11V" . $hvmv . "'
 						     OR Substation = '12S" . $hvmv . "' OR Substation = '12V" . $hvmv . "'
 						     OR Substation = '13S" . $hvmv . "' OR Substation = '13V" . $hvmv . "'
							 OR Substation = '21S" . $hvmv . "' OR Substation = '21V" . $hvmv . "'
							 OR Substation = '22S" . $hvmv . "' OR Substation = '22V" . $hvmv . "'
							 OR Substation = '23S" . $hvmv . "' OR Substation = '23V" . $hvmv . "'
							 OR Substation = '31S" . $hvmv . "' OR Substation = '31V" . $hvmv . "'
							 OR Substation = '32S" . $hvmv . "' OR Substation = '32V" . $hvmv . "'
							 OR Substation = '33S" . $hvmv . "' OR Substation = '33V" . $hvmv . "'
							 OR Substation = '41S" . $hvmv . "' OR Substation = '41V" . $hvmv . "'
							 OR Substation = '42S" . $hvmv . "' OR Substation = '42V" . $hvmv . "'
							 OR Substation = '43S" . $hvmv . "' OR Substation = '43V" . $hvmv . "')";
                    } else { // $hvmv, $type
                        $query_tmp = "
						 WHERE (Substation = '11S" . $hvmv . "' OR Substation = '11V" . $hvmv . "'
 						     OR Substation = '12S" . $hvmv . "' OR Substation = '12V" . $hvmv . "'
 						     OR Substation = '13S" . $hvmv . "' OR Substation = '13V" . $hvmv . "'
							 OR Substation = '21S" . $hvmv . "' OR Substation = '21V" . $hvmv . "'
							 OR Substation = '22S" . $hvmv . "' OR Substation = '22V" . $hvmv . "'
							 OR Substation = '23S" . $hvmv . "' OR Substation = '23V" . $hvmv . "'
							 OR Substation = '31S" . $hvmv . "' OR Substation = '31V" . $hvmv . "'
							 OR Substation = '32S" . $hvmv . "' OR Substation = '32V" . $hvmv . "'
							 OR Substation = '33S" . $hvmv . "' OR Substation = '33V" . $hvmv . "'
							 OR Substation = '41S" . $hvmv . "' OR Substation = '41V" . $hvmv . "'
							 OR Substation = '42S" . $hvmv . "' OR Substation = '42V" . $hvmv . "'
							 OR Substation = '43S" . $hvmv . "' OR Substation = '43V" . $hvmv . "')
							 AND feeder like '" . $type . "%'";
                    }
                }
            } else { // $province
                $query = "";
            }
        } else { // $sppvspp
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = "
						WHERE (Substation = '11" . $sppvspp . "H' OR Substation = '11" . $sppvspp . "M'
 						     OR Substation = '12" . $sppvspp . "H' OR Substation = '12" . $sppvspp . "M'
  						     OR Substation = '13" . $sppvspp . "H' OR Substation = '13" . $sppvspp . "M'
  						     OR Substation = '21" . $sppvspp . "H' OR Substation = '21" . $sppvspp . "M'
	 					     OR Substation = '22" . $sppvspp . "H' OR Substation = '22" . $sppvspp . "M'
						     OR Substation = '23" . $sppvspp . "H' OR Substation = '23" . $sppvspp . "M'
						     OR Substation = '31" . $sppvspp . "H' OR Substation = '31" . $sppvspp . "M'
						     OR Substation = '32" . $sppvspp . "H' OR Substation = '32" . $sppvspp . "M'
						     OR Substation = '33" . $sppvspp . "H' OR Substation = '33" . $sppvspp . "M'
					         OR Substation = '41" . $sppvspp . "H' OR Substation = '41" . $sppvspp . "M'
						     OR Substation = '42" . $sppvspp . "H' OR Substation = '42" . $sppvspp . "M'
					         OR Substation = '43" . $sppvspp . "H' OR Substation = '43" . $sppvspp . "M')";
                    } else { // $type
                        $query_tmp = "
						WHERE (Substation = '11" . $sppvspp . "H' OR Substation = '11" . $sppvspp . "M'
 						     OR Substation = '12" . $sppvspp . "H' OR Substation = '12" . $sppvspp . "M'
  						     OR Substation = '13" . $sppvspp . "H' OR Substation = '13" . $sppvspp . "M'
  						     OR Substation = '21" . $sppvspp . "H' OR Substation = '21" . $sppvspp . "M'
	 					     OR Substation = '22" . $sppvspp . "H' OR Substation = '22" . $sppvspp . "M'
						     OR Substation = '23" . $sppvspp . "H' OR Substation = '23" . $sppvspp . "M'
						     OR Substation = '31" . $sppvspp . "H' OR Substation = '31" . $sppvspp . "M'
						     OR Substation = '32" . $sppvspp . "H' OR Substation = '32" . $sppvspp . "M'
						     OR Substation = '33" . $sppvspp . "H' OR Substation = '33" . $sppvspp . "M'
					         OR Substation = '41" . $sppvspp . "H' OR Substation = '41" . $sppvspp . "M'
						     OR Substation = '42" . $sppvspp . "H' OR Substation = '42" . $sppvspp . "M'
					         OR Substation = '43" . $sppvspp . "H' OR Substation = '43" . $sppvspp . "M')
							 AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = "
                         WHERE (Substation = '11" . $sppvspp . $hvmv . "'
 						     OR Substation = '12" . $sppvspp . $hvmv . "'
  						     OR Substation = '13" . $sppvspp . $hvmv . "'
  						     OR Substation = '21" . $sppvspp . $hvmv . "'
	 					     OR Substation = '22" . $sppvspp . $hvmv . "'
						     OR Substation = '23" . $sppvspp . $hvmv . "'
						     OR Substation = '31" . $sppvspp . $hvmv . "'
						     OR Substation = '32" . $sppvspp . $hvmv . "'
						     OR Substation = '33" . $sppvspp . $hvmv . "'
					         OR Substation = '41" . $sppvspp . $hvmv . "'
						     OR Substation = '42" . $sppvspp . $hvmv . "'
					         OR Substation = '43" . $sppvspp . $hvmv . "')";
                    } else { // $hvmv, $type
                        $query_tmp = "
						WHERE (Substation = '11" . $sppvspp . $hvmv . "'
 						     OR Substation = '12" . $sppvspp . $hvmv . "'
  						     OR Substation = '13" . $sppvspp . $hvmv . "'
  						     OR Substation = '21" . $sppvspp . $hvmv . "'
	 					     OR Substation = '22" . $sppvspp . $hvmv . "'
						     OR Substation = '23" . $sppvspp . $hvmv . "'
						     OR Substation = '31" . $sppvspp . $hvmv . "'
						     OR Substation = '32" . $sppvspp . $hvmv . "'
						     OR Substation = '33" . $sppvspp . $hvmv . "'
					         OR Substation = '41" . $sppvspp . $hvmv . "'
						     OR Substation = '42" . $sppvspp . $hvmv . "'
					         OR Substation = '43" . $sppvspp . $hvmv . "')
							 AND feeder like '" . $type . "%'";
                    }
                }
            }
        }
        $query = $query1 . $query_tmp . $query2 . $query_tmp . $query3;
    } else { // $area <> "Total"
        $query1 = "SELECT date, time, 'Total' AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query2 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time
              UNION
              SELECT date, time, RIGHT(RTRIM(Feeder),2) AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query3 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time, RIGHT(RTRIM(Feeder),2)
              ORDER BY Bay, date, time";

	//$query1="";
	//$query2="SELECT date, time, Area, Bay, SUM(Load) AS mw FROM Bay_Load";
	//$query3=" AND date = '$last_date' AND time >= '$last_time'
	//		  AND Area = '".$area."'
    //          GROUP BY date, time, Area, Bay
    //          ORDER BY date, time";
        switch ($area) {
            case "N1":
                $areacode = "11";
                break;
            case "N2":
                $areacode = "12";
                break;
            case "N3":
                $areacode = "13";
                break;
            case "NE1":
                $areacode = "21";
                break;
            case "NE2":
                $areacode = "22";
                break;
            case "NE3":
                $areacode = "23";
                break;
            case "C1":
                $areacode = "31";
                break;
            case "C2":
                $areacode = "32";
                break;
            case "C3":
                $areacode = "33";
                break;
            case "S1":
                $areacode = "41";
                break;
            case "S2":
                $areacode = "42";
                break;
            case "S3":
                $areacode = "43";
                break;
        }
        if ($sppvspp == "Total") {
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . "SH' OR Substation = '" . $areacode . "SM'
						                   OR Substation = '" . $areacode . "VH' OR Substation = '" . $areacode . "VM')";
                    } else { // $type
                        $query_tmp = " WHERE (Substation = '" . $areacode . "SH' OR Substation = '" . $areacode . "SM'
						                   OR Substation = '" . $areacode . "VH' OR Substation = '" . $areacode . "VM')
										   AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . "S" . $hvmv . "' OR Substation = '" . $areacode . "V" . $hvmv . "')";
                    } else { // $hvmv, $type

                        $query_tmp = " WHERE (Substation = '" . $areacode . "S" . $hvmv . "' OR Substation = '" . $areacode . "V" . $hvmv . "')
						 AND feeder like '" . $type . "%'";
                    }
                }
            } else { // $province
/*                if($hvmv == "Total"){
                    if($type == "Total"){
                        $query_tmp = " WHERE (Substation = '".$areacode."SH' OR Substation = '".$areacode."SM'
						                   OR Substation = '".$areacode."VH' OR Substation = '".$areacode."VM')
										   AND RIGHT(RTRIM(feeder),2) = '".$province."'";
                    }
                    else{ // $type
						$query_tmp = " WHERE (Substation = '".$areacode."SH' OR Substation = '".$areacode."SM'
						                   OR Substation = '".$areacode."VH' OR Substation = '".$areacode."VM')
										   AND feeder like '".$type."%'";
                    }
                }
				else{ // $hvmv
					if($type == "Total"){
                         $query_tmp = " WHERE (Substation = '".$areacode."S".$hvmv."' OR Substation = '".$areacode."V".$hvmv."')";
                    }
                    else{ // $hvmv, $type

                         $query_tmp = " WHERE (Substation = '".$areacode."S".$hvmv."' OR Substation = '".$areacode."V".$hvmv."')
						 AND feeder like '".$type."%'";
                    }
				}
                 */
            }
        } else { // $sppvspp
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . "H' OR Substation = '" . $areacode . $sppvspp . "M')";
                    } else { // $type
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . "H' OR Substation = '" . $areacode . $sppvspp . "M')
						AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . $hvmv . "H')";
                    } else { // $type
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . $hvmv . "')
						AND feeder like '" . $type . "%'";
                    }
                }
            }
        }
        $query = $query1 . $query_tmp . $query2 . $query_tmp . $query3;
    }
    //echo $query;

    $output['query'] = $query;
    $output['database server'] = $GLOBALS['DATABASE_SERVER_IP'];
    $output['get param'] = $_GET['server'];
    ini_set('max_execution_time', 120);
    ini_set('mssql.connect_timeout', 120);
    ini_set('mssql.timeout', 120);
    set_time_limit (120);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Query = ".$query."<br/>Error sending query to SQL Server database.<br/>");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    $total = 0;
    $lastDatetime = '';

    $data2 = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Bay][$datetime] = $row->mw;
            $data2[$row->Bay][$row->time] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
        }
    }

    $nameArr = array();
    $labelArr = array();

	//mssql_close($conn);
	//$conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Substation", $conn) === false) {
        die("Cannot connect or select SQL Server database (Substation)");
    }

    if ($area != "Total") {
        if ($province == 'Total') {
            $query = "SELECT RIGHT(ISO,2) as Code,EnProvince FROM RegProName WHERE RegionCode = '" . $area . "' ORDER BY EnProvince";
			//echo $query;
            $result = mssql_query($query);
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Code);
                array_push($labelArr, $row->EnProvince);
            }
            array_push($nameArr, 'Total');
            array_push($labelArr, 'Total');
        } else {
            $query = "SELECT RIGHT(ISO,2) as Code,EnProvince FROM RegProName WHERE RegionCode = '" . $area . "'
			          AND RIGHT(ISO,2) = '" . $province . "'";
            $result = mssql_query($query);
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Province);
                array_push($labelArr, $row->EnglishName);
            }
        }
    } else {
        array_push($nameArr, '11');
        array_push($labelArr, 'N1');
        array_push($nameArr, '12');
        array_push($labelArr, 'N2');
        array_push($nameArr, '13');
        array_push($labelArr, 'N3');
        array_push($nameArr, '21');
        array_push($labelArr, 'NE1');
        array_push($nameArr, '22');
        array_push($labelArr, 'NE2');
        array_push($nameArr, '23');
        array_push($labelArr, 'NE3');
        array_push($nameArr, '31');
        array_push($labelArr, 'C1');
        array_push($nameArr, '32');
        array_push($labelArr, 'C2');
        array_push($nameArr, '33');
        array_push($labelArr, 'C3');
        array_push($nameArr, '41');
        array_push($labelArr, 'S1');
        array_push($nameArr, '42');
        array_push($labelArr, 'S2');
        array_push($nameArr, '43');
        array_push($labelArr, 'S3');
        array_push($nameArr, 'Total');
        array_push($labelArr, 'Total');
    }
    mssql_close($conn);

    $output['name'] = $nameArr;
    $output['label'] = $labelArr;
    $output['area'] = $area;

    return $output;
}

function get_load_data_spp_vspp_province_beta($day, $area, $sppvspp, $province, $hvmv, $type)
{
    include "db_connection.php";

    if (is_null($province)) {
        $province = 'Total';
    }

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "";
    $query_tmp = "";

    $output['12Area'] = 0;

    //Lookup Table
    $area2Code = array("N1" => "11", "N2" => "12", "N3" => "13", "NE1" => "21", "NE2" => "22", "NE3" => "23", "C1" => "31", "C2" => "32", "C3" => "33", "S1" => "41", "S2" => "42", "S3" => "43");

    if ($area == "Total") {
        if ($sppvspp == "Total") {
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query = "SELECT date, time, 'Total' AS Bay, SUM(Load) AS mw
                            FROM Bay_Load
                            WHERE Sub like '[1-4][1-3]%'
                            AND date = '$last_date' AND time >= '$last_time'
                            GROUP BY date, time
                            UNION
                            SELECT date, time, Area AS Bay, SUM(Load) AS mw
                            FROM Bay_Load
                            WHERE Sub like '[1-4][1-3]%'
                            AND date = '$last_date' AND time >= '$last_time'
                            GROUP BY date, time, Area
                            ORDER BY Bay, date, time";
                            //$output['12Area'] = 1;
                    } else {
                        $query = "";
                    }
                }
            } else {
                $query = "SELECT date, time, Sub, Bay, Load AS mw
                    FROM Bay_Load
                    WHERE date = '$last_date' AND time >= '$last_time'
                    AND Sub = '$area'
                    AND Bay = '$province'";
            }
        } else {
            $query = "";
        }
    } else {
        if ($sppvspp == "Total") {
            if ($province == "Total") {
                $query = "SELECT date, time, 'Total' AS Sub, 'Total' AS Bay, SUM(Load) AS mw
                    FROM Bay_Load
                    WHERE date = '$last_date' AND time >= '$last_time'
                    AND Sub = '$area'
                    AND Bay <> 'UF'
                    GROUP BY date, time
                    UNION
                    SELECT date, time, Sub, Bay, Load AS mw
                    FROM Bay_Load
                    WHERE date = '$last_date' AND time >= '$last_time'
                    AND Sub = '$area'";
            } else {
                $query = "SELECT date, time, Sub, Bay, Load AS mw
                    FROM Bay_Load
                    WHERE date = '$last_date' AND time >= '$last_time'
                    AND Sub = '$area'
                    AND Bay = '$province'
                    UNION
                    SELECT NULL AS date, time, 'AVG' AS Sub, 'AVG' AS Bay, AVG(Load) AS mw
                    FROM Bay_Load
                    WHERE date >= '$last_date' AND date <= '$last_date'
                    AND Sub = '$area'
                    AND Bay = '$province'
                    GROUP BY time";
            }
        } else {
            if ($province == "Total") {
                $query = "";
            } else {
                if ($hvmv == "Total") {
                    $query = "";
                } else {
                    if ($type == "Total") {
                        $query = "";
                    } else {
                        $query = "SELECT date, time, Bay, SUM(Load) AS mw
                            FROM Bay_Load
                            WHERE Sub = '" . $area2Code[$area] . $sppvspp . $hvmv . $type . "A'
                            AND Bay = '$province'
                            AND date = '$last_date' AND time >= '$last_time'
                            GROUP BY date, time, Bay
                            ORDER BY date, time";
                    }
                }
            }
        }
    }

    $output['query'] = $query;
    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.<br/>");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    /*while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            if($row->Sub == 'Total'){
                $data[$row->Sub][$datetime] = $row->mw;
            }
            else{
                $data[$row->Bay][$datetime] = $row->mw;
            }

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }*/

    $data2 = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Bay][$datetime] = $row->mw;
            $data2[$row->Bay][$row->time] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
        }
    }

    $dbc = mysqli_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql, $DataBaseName_mysql);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $dbc->set_charset('utf8');

    $nameArr = array();
    $labelArr = array();

    if ($area != "Total") {
        if ($province == 'Total') {
            $query = "SELECT * FROM province WHERE Area = '$area'";
            $result = mssql_query($query);
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Province);
                array_push($labelArr, $row->EnglishName);
            }
            array_push($nameArr, 'Total');
            array_push($labelArr, 'Total');
        } else {
            $query = "SELECT * FROM province WHERE Area = '$area' AND Province = '$province'";
            $result = mssql_query($query);
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Province);
                array_push($labelArr, $row->EnglishName);
            }
        }
    } else {
        $query = "SELECT DISTINCT Area FROM province";
        $result = mssql_query($query);
        while ($row = mssql_fetch_object($result)) {
            array_push($nameArr, $row->Area);
            array_push($labelArr, $row->Area);
        }
        array_push($nameArr, 'Total');
        array_push($labelArr, 'Total');
    }

    mssql_close($conn);
    mysqli_close($dbc);

    $output['name'] = $nameArr;
    $output['label'] = $labelArr;
    $output['area'] = $area;

    return $output;
}

function get_load_data_province_monthly($day, $dayStop, $area, $province)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $dataMin = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    $dayStop = date_create_from_format("d-m-Y", $dayStop)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day);
    $start_date = date("Y-m-d", $day);
    $last_date = date("Y-m-d", $dayStop);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    if($province == "Total"){
        $query = $query = "SELECT [date], MAX(subload) as mwMax, MIN(subload) as mwMin
        FROM SCADA.dbo.LOAD_$year
        WHERE substation = '$area'
        AND RTRIM(feeder)='$province'
        AND date >= '$start_date' AND time <= '$start_date'
        GROUP BY [date]
        ORDER BY [date]";
    }
    else{
        $query = "SELECT [date], MAX(subload) as mwMax, MIN(subload) as mwMin
        FROM SCADA.dbo.LOAD_$year
        WHERE substation = '$area'
        AND RTRIM(feeder)='$province'
        AND date >= '$start_date' AND time <= '$start_date'
        GROUP BY [date]
        ORDER BY [date]";
    }


    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    /*while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            if($row->Sub == 'Total'){
                $data[$row->Sub][$datetime] = $row->mw;
            }
            else{
                $data[$row->Bay][$datetime] = $row->mw;
            }

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }*/

    //$output['name'] = array();
    //$output['values'] = array();
    //$output['tprate'] = array();

    while ($row = mssql_fetch_object($result)) {
        /*if (!in_array($row->Bay, $output['name'])) {
            array_push($output['name'], $row->Bay);
            $output['tprate'][$row->Bay] = $row->mw;
        }*/
        //$datetime = "$row->date $row->time";
        //$data[$row->Bay][$datetime] = $row->mw;
        //$data2[$row->Bay][$row->date] = $row->mwMax;
        $data2[$row->date] = $row->mwMax;
        //$dataPercentUT[$row->Bay][$row->date] = $row->PercentUtilization;
        //$dataMin[$row->Bay][$row->date] = $row->mwMin;
        $dataMin[$row->date] = $row->mwMin;
        //$dataPercentUTMin[$row->Bay][$row->date] = $row->PercentUtilizationMin;

        /*if (in_array($datetime, $category) === false) {
            $category[] = $datetime;
        }*/
    }

    //$output["raw"] = $dataPercentUT;
    //$output['values'] = array();

    $output["categories"] = array();
    while (strtotime($start_date) <= strtotime($last_date)) {
        array_push($output["categories"], $start_date);
        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
    }

    $output['values']['max'] = array();
    foreach ($data2 as $sub => $item) {
        //$output['valuesMax'][$sub] = number_format($item, 2, ".", "");
        array_push($output['values']['max'], number_format($item, 2, ".", ""));
    }

    /*foreach ($data2 as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['valuesmin'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }
    }*/

    /*foreach ($dataPercentUT as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['valuesPercent'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['valuesPercent'][$sub][] = null;
            }
        }
    }*/
    $output['values']['min'] = array();
    foreach ($dataMin as $sub => $item) {
        //$output['valuesMin'][$sub] = number_format($item, 2, ".", "");
        array_push($output['values']['min'], number_format($item, 2, ".", ""));
    }

    /*foreach ($dataPercentUTMin as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['valuesPercentMin'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['valuesPercentMin'][$sub][] = null;
            }
        }
    }*/

    //$dbc = mysqli_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql, $DataBaseName_mysql);

    // Check connection
    /*if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $dbc->set_charset('utf8');

    $nameArr = array();
    $labelArr = array();*/

    mssql_close($conn);
    //mysqli_close($dbc);

    /*$output['name'] = $nameArr;
    $output['label'] = $labelArr;*/
    $output['name'] = array("max","min");
    $output['label'] = array("max","min");
    $output['area'] = $area;

    return $output;
}

function get_load_data_spp_vspp_province($day, $area, $sppvspp, $province, $hvmv, $type)
{
    include "db_connection.php";

    if (is_null($province)) {
        $province = 'Total';
    }

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    // $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");
    // $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
    $conn = mssql_connect($GLOBALS['DATABASE_SERVER_IP'], "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day);
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "";
    $query_tmp = "";
    $query1 = "";
    $query2 = "";
    $query3 = "";

    $output['12Area'] = 0;

    //Lookup Table
    $area2Code = array("N1" => "11", "N2" => "12", "N3" => "13", "NE1" => "21", "NE2" => "22", "NE3" => "23", "C1" => "31", "C2" => "32", "C3" => "33", "S1" => "41", "S2" => "42", "S3" => "43");

    if ($area == "Total") {
        $query1 = "SELECT date, time, 'Total' AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query2 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time
              UNION
              SELECT date, time, LEFT(substation,2) AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query3 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time, LEFT(substation,2)
              ORDER BY Bay, date, time";
        if ($sppvspp == "Total") {
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = "
						WHERE (Substation = '11SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'
 						    OR Substation = '12SH' OR Substation = '12SM' OR Substation = '12VH' OR Substation = '12VM'
 						    OR Substation = '13SH' OR Substation = '13SM' OR Substation = '13VH' OR Substation = '13VM'
 						    OR Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'
						    OR Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'
						    OR Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'
						    OR Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'
						    OR Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'
						    OR Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'
					        OR Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'
						    OR Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'
					        OR Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM')";
                            //$output['12Area'] = 1;
                    } else { // $type
                        $query_tmp = "
						WHERE (Substation = '11SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'
 						    OR Substation = '12SH' OR Substation = '12SM' OR Substation = '12VH' OR Substation = '12VM'
 						    OR Substation = '13SH' OR Substation = '13SM' OR Substation = '13VH' OR Substation = '13VM'
 						    OR Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'
						    OR Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'
						    OR Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'
						    OR Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'
						    OR Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'
						    OR Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'
					        OR Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'
						    OR Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'
					        OR Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM')
							AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = "
						 WHERE (Substation = '11S" . $hvmv . "' OR Substation = '11V" . $hvmv . "'
 						     OR Substation = '12S" . $hvmv . "' OR Substation = '12V" . $hvmv . "'
 						     OR Substation = '13S" . $hvmv . "' OR Substation = '13V" . $hvmv . "'
							 OR Substation = '21S" . $hvmv . "' OR Substation = '21V" . $hvmv . "'
							 OR Substation = '22S" . $hvmv . "' OR Substation = '22V" . $hvmv . "'
							 OR Substation = '23S" . $hvmv . "' OR Substation = '23V" . $hvmv . "'
							 OR Substation = '31S" . $hvmv . "' OR Substation = '31V" . $hvmv . "'
							 OR Substation = '32S" . $hvmv . "' OR Substation = '32V" . $hvmv . "'
							 OR Substation = '33S" . $hvmv . "' OR Substation = '33V" . $hvmv . "'
							 OR Substation = '41S" . $hvmv . "' OR Substation = '41V" . $hvmv . "'
							 OR Substation = '42S" . $hvmv . "' OR Substation = '42V" . $hvmv . "'
							 OR Substation = '43S" . $hvmv . "' OR Substation = '43V" . $hvmv . "')";
                    } else { // $hvmv, $type
                        $query_tmp = "
						 WHERE (Substation = '11S" . $hvmv . "' OR Substation = '11V" . $hvmv . "'
 						     OR Substation = '12S" . $hvmv . "' OR Substation = '12V" . $hvmv . "'
 						     OR Substation = '13S" . $hvmv . "' OR Substation = '13V" . $hvmv . "'
							 OR Substation = '21S" . $hvmv . "' OR Substation = '21V" . $hvmv . "'
							 OR Substation = '22S" . $hvmv . "' OR Substation = '22V" . $hvmv . "'
							 OR Substation = '23S" . $hvmv . "' OR Substation = '23V" . $hvmv . "'
							 OR Substation = '31S" . $hvmv . "' OR Substation = '31V" . $hvmv . "'
							 OR Substation = '32S" . $hvmv . "' OR Substation = '32V" . $hvmv . "'
							 OR Substation = '33S" . $hvmv . "' OR Substation = '33V" . $hvmv . "'
							 OR Substation = '41S" . $hvmv . "' OR Substation = '41V" . $hvmv . "'
							 OR Substation = '42S" . $hvmv . "' OR Substation = '42V" . $hvmv . "'
							 OR Substation = '43S" . $hvmv . "' OR Substation = '43V" . $hvmv . "')
							 AND feeder like '" . $type . "%'";
                    }
                }
            } else { // $province
                $query = "";
            }
        } else { // $sppvspp
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = "
						WHERE (Substation = '11" . $sppvspp . "H' OR Substation = '11" . $sppvspp . "M'
 						     OR Substation = '12" . $sppvspp . "H' OR Substation = '12" . $sppvspp . "M'
  						     OR Substation = '13" . $sppvspp . "H' OR Substation = '13" . $sppvspp . "M'
  						     OR Substation = '21" . $sppvspp . "H' OR Substation = '21" . $sppvspp . "M'
	 					     OR Substation = '22" . $sppvspp . "H' OR Substation = '22" . $sppvspp . "M'
						     OR Substation = '23" . $sppvspp . "H' OR Substation = '23" . $sppvspp . "M'
						     OR Substation = '31" . $sppvspp . "H' OR Substation = '31" . $sppvspp . "M'
						     OR Substation = '32" . $sppvspp . "H' OR Substation = '32" . $sppvspp . "M'
						     OR Substation = '33" . $sppvspp . "H' OR Substation = '33" . $sppvspp . "M'
					         OR Substation = '41" . $sppvspp . "H' OR Substation = '41" . $sppvspp . "M'
						     OR Substation = '42" . $sppvspp . "H' OR Substation = '42" . $sppvspp . "M'
					         OR Substation = '43" . $sppvspp . "H' OR Substation = '43" . $sppvspp . "M')";
                    } else { // $type
                        $query_tmp = "
						WHERE (Substation = '11" . $sppvspp . "H' OR Substation = '11" . $sppvspp . "M'
 						     OR Substation = '12" . $sppvspp . "H' OR Substation = '12" . $sppvspp . "M'
  						     OR Substation = '13" . $sppvspp . "H' OR Substation = '13" . $sppvspp . "M'
  						     OR Substation = '21" . $sppvspp . "H' OR Substation = '21" . $sppvspp . "M'
	 					     OR Substation = '22" . $sppvspp . "H' OR Substation = '22" . $sppvspp . "M'
						     OR Substation = '23" . $sppvspp . "H' OR Substation = '23" . $sppvspp . "M'
						     OR Substation = '31" . $sppvspp . "H' OR Substation = '31" . $sppvspp . "M'
						     OR Substation = '32" . $sppvspp . "H' OR Substation = '32" . $sppvspp . "M'
						     OR Substation = '33" . $sppvspp . "H' OR Substation = '33" . $sppvspp . "M'
					         OR Substation = '41" . $sppvspp . "H' OR Substation = '41" . $sppvspp . "M'
						     OR Substation = '42" . $sppvspp . "H' OR Substation = '42" . $sppvspp . "M'
					         OR Substation = '43" . $sppvspp . "H' OR Substation = '43" . $sppvspp . "M')
							 AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = "
                         WHERE (Substation = '11" . $sppvspp . $hvmv . "'
 						     OR Substation = '12" . $sppvspp . $hvmv . "'
  						     OR Substation = '13" . $sppvspp . $hvmv . "'
  						     OR Substation = '21" . $sppvspp . $hvmv . "'
	 					     OR Substation = '22" . $sppvspp . $hvmv . "'
						     OR Substation = '23" . $sppvspp . $hvmv . "'
						     OR Substation = '31" . $sppvspp . $hvmv . "'
						     OR Substation = '32" . $sppvspp . $hvmv . "'
						     OR Substation = '33" . $sppvspp . $hvmv . "'
					         OR Substation = '41" . $sppvspp . $hvmv . "'
						     OR Substation = '42" . $sppvspp . $hvmv . "'
					         OR Substation = '43" . $sppvspp . $hvmv . "')";
                    } else { // $hvmv, $type
                        $query_tmp = "
						WHERE (Substation = '11" . $sppvspp . $hvmv . "'
 						     OR Substation = '12" . $sppvspp . $hvmv . "'
  						     OR Substation = '13" . $sppvspp . $hvmv . "'
  						     OR Substation = '21" . $sppvspp . $hvmv . "'
	 					     OR Substation = '22" . $sppvspp . $hvmv . "'
						     OR Substation = '23" . $sppvspp . $hvmv . "'
						     OR Substation = '31" . $sppvspp . $hvmv . "'
						     OR Substation = '32" . $sppvspp . $hvmv . "'
						     OR Substation = '33" . $sppvspp . $hvmv . "'
					         OR Substation = '41" . $sppvspp . $hvmv . "'
						     OR Substation = '42" . $sppvspp . $hvmv . "'
					         OR Substation = '43" . $sppvspp . $hvmv . "')
							 AND feeder like '" . $type . "%'";
                    }
                }
            }
        }
        $query = $query1 . $query_tmp . $query2 . $query_tmp . $query3;
    } else { // $area <> "Total"
        $query1 = "SELECT date, time, 'Total' AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query2 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time
              UNION
              SELECT date, time, RIGHT(RTRIM(Feeder),2) AS Bay, SUM(subload) AS mw FROM LOAD_$year";
        $query3 = " AND date = '$last_date' AND time >= '$last_time'
              GROUP BY date, time, RIGHT(RTRIM(Feeder),2)
              ORDER BY Bay, date, time";

	//$query1="";
	//$query2="SELECT date, time, Area, Bay, SUM(Load) AS mw FROM Bay_Load";
	//$query3=" AND date = '$last_date' AND time >= '$last_time'
	//		  AND Area = '".$area."'
    //          GROUP BY date, time, Area, Bay
    //          ORDER BY date, time";
        switch ($area) {
            case "N1":
                $areacode = "11";
                break;
            case "N2":
                $areacode = "12";
                break;
            case "N3":
                $areacode = "13";
                break;
            case "NE1":
                $areacode = "21";
                break;
            case "NE2":
                $areacode = "22";
                break;
            case "NE3":
                $areacode = "23";
                break;
            case "C1":
                $areacode = "31";
                break;
            case "C2":
                $areacode = "32";
                break;
            case "C3":
                $areacode = "33";
                break;
            case "S1":
                $areacode = "41";
                break;
            case "S2":
                $areacode = "42";
                break;
            case "S3":
                $areacode = "43";
                break;
        }
        if ($sppvspp == "Total") {
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . "SH' OR Substation = '" . $areacode . "SM'
						                   OR Substation = '" . $areacode . "VH' OR Substation = '" . $areacode . "VM')";
                    } else { // $type
                        $query_tmp = " WHERE (Substation = '" . $areacode . "SH' OR Substation = '" . $areacode . "SM'
						                   OR Substation = '" . $areacode . "VH' OR Substation = '" . $areacode . "VM')
										   AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . "S" . $hvmv . "' OR Substation = '" . $areacode . "V" . $hvmv . "')";
                    } else { // $hvmv, $type

                        $query_tmp = " WHERE (Substation = '" . $areacode . "S" . $hvmv . "' OR Substation = '" . $areacode . "V" . $hvmv . "')
						 AND feeder like '" . $type . "%'";
                    }
                }
            } else { // $province
/*                if($hvmv == "Total"){
                    if($type == "Total"){
                        $query_tmp = " WHERE (Substation = '".$areacode."SH' OR Substation = '".$areacode."SM'
						                   OR Substation = '".$areacode."VH' OR Substation = '".$areacode."VM')
										   AND RIGHT(RTRIM(feeder),2) = '".$province."'";
                    }
                    else{ // $type
						$query_tmp = " WHERE (Substation = '".$areacode."SH' OR Substation = '".$areacode."SM'
						                   OR Substation = '".$areacode."VH' OR Substation = '".$areacode."VM')
										   AND feeder like '".$type."%'";
                    }
                }
				else{ // $hvmv
					if($type == "Total"){
                         $query_tmp = " WHERE (Substation = '".$areacode."S".$hvmv."' OR Substation = '".$areacode."V".$hvmv."')";
                    }
                    else{ // $hvmv, $type

                         $query_tmp = " WHERE (Substation = '".$areacode."S".$hvmv."' OR Substation = '".$areacode."V".$hvmv."')
						 AND feeder like '".$type."%'";
                    }
				}
                 */
            }
        } else { // $sppvspp
            if ($province == "Total") {
                if ($hvmv == "Total") {
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . "H' OR Substation = '" . $areacode . $sppvspp . "M')";
                    } else { // $type
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . "H' OR Substation = '" . $areacode . $sppvspp . "M')
						AND feeder like '" . $type . "%'";
                    }
                } else { // $hvmv
                    if ($type == "Total") {
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . $hvmv . "H')";
                    } else { // $type
                        $query_tmp = " WHERE (Substation = '" . $areacode . $sppvspp . $hvmv . "')
						AND feeder like '" . $type . "%'";
                    }
                }
            }
        }
        $query = $query1 . $query_tmp . $query2 . $query_tmp . $query3;
    }
    //echo $query;

    $output['query'] = $query;
    $output['database server'] = $GLOBALS['DATABASE_SERVER_IP'];
    $output['get param'] = $_GET['server'];
    ini_set('max_execution_time', 120);
    ini_set('mssql.connect_timeout', 120);
    ini_set('mssql.timeout', 120);
    set_time_limit (120);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Query = ".$query."<br/>Error sending query to SQL Server database.<br/>");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    $total = 0;
    $lastDatetime = '';

    $data2 = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Bay][$datetime] = $row->mw;
            $data2[$row->Bay][$row->time] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');
    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
        }
    }

    $nameArr = array();
    $labelArr = array();

	//mssql_close($conn);
	//$conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Substation", $conn) === false) {
        die("Cannot connect or select SQL Server database (Substation)");
    }

    if ($area != "Total") {
        if ($province == 'Total') {
            $query = "SELECT RIGHT(ISO,2) as Code,EnProvince FROM RegProName WHERE RegionCode = '" . $area . "' ORDER BY EnProvince";
			//echo $query;
            $result = mssql_query($query);
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Code);
                array_push($labelArr, $row->EnProvince);
            }
            array_push($nameArr, 'Total');
            array_push($labelArr, 'Total');
        } else {
            $query = "SELECT RIGHT(ISO,2) as Code,EnProvince FROM RegProName WHERE RegionCode = '" . $area . "'
			          AND RIGHT(ISO,2) = '" . $province . "'";
            $result = mssql_query($query);
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Province);
                array_push($labelArr, $row->EnglishName);
            }
        }
    } else {
        array_push($nameArr, '11');
        array_push($labelArr, 'N1');
        array_push($nameArr, '12');
        array_push($labelArr, 'N2');
        array_push($nameArr, '13');
        array_push($labelArr, 'N3');
        array_push($nameArr, '21');
        array_push($labelArr, 'NE1');
        array_push($nameArr, '22');
        array_push($labelArr, 'NE2');
        array_push($nameArr, '23');
        array_push($labelArr, 'NE3');
        array_push($nameArr, '31');
        array_push($labelArr, 'C1');
        array_push($nameArr, '32');
        array_push($labelArr, 'C2');
        array_push($nameArr, '33');
        array_push($labelArr, 'C3');
        array_push($nameArr, '41');
        array_push($labelArr, 'S1');
        array_push($nameArr, '42');
        array_push($labelArr, 'S2');
        array_push($nameArr, '43');
        array_push($labelArr, 'S3');
        array_push($nameArr, 'Total');
        array_push($labelArr, 'Total');
    }
    mssql_close($conn);

    $output['name'] = $nameArr;
    $output['label'] = $labelArr;
    $output['area'] = $area;

    return $output;
}

function get_load_data_feeder($day, $area, $substation)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    //$conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database (data.php)");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day);
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT date, time, substation as Sub, feeder as Bay, subload AS mw
        FROM SCADA.dbo.LOAD_$year
        WHERE date = '$last_date' AND time >= '$last_time'
        AND substation = '$substation'
        ORDER BY Bay";

    //$output['query'] = $query;

    //ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database. <data.php Line:729>");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    $total = 0;
    $lastDatetime = '';

    $output['name'] = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            if (!in_array($row->Bay, $output['name'])) {
                array_push($output['name'], $row->Bay);
            }
            $datetime = "$row->date $row->time";
            $data[$row->Bay][$datetime] = $row->mw;
            $data2[$row->Bay][$row->time] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["raw"] = $data2;

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
        }
    }

    $nameArr = array();
    $labelArr = array();

    mssql_close($conn);

    $output['area'] = $area;

    return $output;
}

function get_load_data_feeder_monthly($day, $dayStop, $area, $substation)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $dataMin = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    //$conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database (data.php)");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    $dayStop = date_create_from_format("d-m-Y", $dayStop)->getTimestamp();
    //$midnight = strtotime("today midnight");
    //$last_date = date("Y-m-d", $day);
    $year = date("Y", $day);
    $start_date = date("Y-m-d", $day);
    $last_date = date("Y-m-d", $dayStop);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT date, substation as Sub, RTRIM(feeder) as Bay, MAX(subload) AS mw, MIN(subload) AS mwMin
        FROM SCADA.dbo.LOAD_$year
        WHERE date >= '$start_date' AND date <= '$last_date'
        AND substation = '$substation'
		GROUP BY date, substation, RTRIM(feeder)
        ORDER BY substation,RTRIM(feeder),date";

    //$output['query'] = $query;

    //ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database. <data.php Line:842>");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    $total = 0;
    $lastDatetime = '';

    $output['name'] = array();

    while ($row = mssql_fetch_object($result)) {

        if (!in_array($row->Bay, $output['name'])) {
            array_push($output['name'], $row->Bay);
        }
            //$datetime = "$row->date $row->time";
        $data2[$row->Bay][$row->date] = $row->mw;
        $dataMin[$row->Bay][$row->date] = $row->mwMin;
            //$data2[$row->Bay][$row->time] = $row->mw;

    }

    $output["raw"] = $data2;

    $output["categories"] = array();
    while (strtotime($start_date) <= strtotime($last_date)) {
        array_push($output["categories"], $start_date);
        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
    }

    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        $count = 0;
        foreach ($output["categories"] as $key => $date) {
            if (array_key_exists($date, $item)) {
                $output['values'][$sub][] = number_format($item[$date], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
            $count++;
        }
    }

    foreach ($dataMin as $sub => $item) {
        $count = 0;
        foreach ($output["categories"] as $key => $date) {
            if (array_key_exists($date, $item)) {
                $output['valuesMin'][$sub][] = number_format($item[$date], 2, ".", "");
            } else {
                $output['valuesMin'][$sub][] = null;
            }
            $count++;
        }
    }

    $nameArr = array();
    $labelArr = array();

    mssql_close($conn);

    $output['area'] = $area;

    return $output;
}

function get_load_data_tp_overview($day, $dayStop)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    $dayStop = date_create_from_format("d-m-Y", $dayStop)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $start_date = date("Y-m-d", $day);
    $last_date = date("Y-m-d", $dayStop);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT s.Area, b.Sub, b.Subname, b.Bay, s.tp, MAX(ABS(b.Load)) AS MAXMW, MAX(ABS(b.Load))/(s.TPRate*0.85)*100 AS PercentUtilization, s.TPRate
            ,(CASE WHEN MAX(ABS(b.Load))/(s.TPRate*0.85)*100 > 80
                THEN 'H'
                WHEN MAX(ABS(b.Load))/(s.TPRate*0.85)*100 >= 50 and MAX(ABS(b.Load))/(s.TPRate*0.85)*100 < 80
                THEN 'M'
                WHEN MAX(ABS(b.Load))/(s.TPRate*0.85)*100 < 50 and MAX(ABS(b.Load))/(s.TPRate*0.85)*100 > 0
                THEN 'L'
                ELSE 'Z' END) AS UTRange
            from Bay_Load b
            inner join substation_tp s on b.Sub = s.Sub and b.Bay COLLATE Thai_CI_AS = s.Bay COLLATE Thai_CI_AS
            where b.date >= '$start_date' and b.date <= '$last_date'
            and s.tp IS NOT NULL
            group by s.Area, b.Sub, b.Subname, b.Bay, s.tp, s.TPRate
            order by s.Area, b.Sub, s.tp";

    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    /*while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            if($row->Sub == 'Total'){
                $data[$row->Sub][$datetime] = $row->mw;
            }
            else{
                $data[$row->Bay][$datetime] = $row->mw;
            }

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }*/

    $output['name'] = array();
    $output['tprate'] = array();

    while ($row = mssql_fetch_object($result)) {
        if (!in_array($row->Bay, $output['name'])) {
            array_push($output['name'], $row->Bay);
            $output['tprate'][$row->Bay] = $row->TPRate;
        }
        //$datetime = "$row->date $row->time";
        //$data[$row->Bay][$datetime] = $row->mw;
        $data2[$row->Bay][$row->date] = $row->mw;
        $dataPercentUT[$row->Bay][$row->date] = $row->PercentUtilization;

        /*if (in_array($datetime, $category) === false) {
            $category[] = $datetime;
        }*/
    }

    $output["raw"] = $dataPercentUT;

    $output["categories"] = array();
    while (strtotime($start_date) <= strtotime($last_date)) {
        array_push($output["categories"], $start_date);
        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
    }

    foreach ($data2 as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        /*for ($i = 96; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }*/
    }

    /*$catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if(array_key_exists($time, $item)){
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            }
            else{
                $output['values'][$sub][] = null;
            }
        }
    }*/

    foreach ($dataPercentUT as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['valuesPercent'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['valuesPercent'][$sub][] = null;
            }
        }
    }

    $dbc = mysqli_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql, $DataBaseName_mysql);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $dbc->set_charset('utf8');

    $nameArr = array();
    $labelArr = array();

    mssql_close($conn);
    mysqli_close($dbc);

    /*$output['name'] = $nameArr;
    $output['label'] = $labelArr;*/
    $output['area'] = $area;

    return $output;
}

function get_load_data_tp_daily_m($day, $dayStop, $area, $substation)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    $dayStop = date_create_from_format("d-m-Y", $dayStop)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    $stop_date = date("Y-m-d", $dayStop);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT b.date, b.time, b.Area, b.Sub, b.Bay COLLATE Thai_CI_AS +' ('+ s.tp COLLATE Thai_CI_AS +')' AS Bay, s.tp, ABS(b.Load) AS mw, ABS(b.Load)/(s.TPRate*0.85)*100 AS PercentUtilization, s.TPRate
        from Bay_Load b
        inner join substation_tp s on b.Sub = s.Sub and b.Bay COLLATE Thai_CI_AS = s.Bay COLLATE Thai_CI_AS
        where b.date >= '$last_date' and b.date <= '$stop_date'
        and s.tp IS NOT NULL
        and b.Sub = '$substation'";

    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';
    $output['query'] = $query;

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    /*while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            if($row->Sub == 'Total'){
                $data[$row->Sub][$datetime] = $row->mw;
            }
            else{
                $data[$row->Bay][$datetime] = $row->mw;
            }

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }*/

    $output['name'] = array();
    $output['tprate'] = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            if (!in_array($row->Bay, $output['name'])) {
                array_push($output['name'], $row->Bay);
                $output['tprate'][$row->Bay] = $row->TPRate;
            }
            $datetime = "$row->date $row->time";
            $data[$row->Bay][$datetime] = $row->mw;
            $data2[$row->Bay][$row->time] = $row->mw;
            $dataPercentUT[$row->Bay][$row->time] = $row->PercentUtilization;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["raw"] = $dataPercentUT;

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    /*foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 96; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }*/

    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
        }
    }

    foreach ($dataPercentUT as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['valuesPercent'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['valuesPercent'][$sub][] = null;
            }
        }
    }

    $dbc = mysqli_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql, $DataBaseName_mysql);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $dbc->set_charset('utf8');

    $nameArr = array();
    $labelArr = array();

    mssql_close($conn);
    mysqli_close($dbc);

    /*$output['name'] = $nameArr;
    $output['label'] = $labelArr;*/
    $output['area'] = $area;

    return $output;
}

function get_load_data_tp_daily($day, $area, $substation)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day);
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

/*    $query = "SELECT b.date, b.time, b.Area, b.Sub, b.Bay COLLATE Thai_CI_AS +' ('+ s.tp COLLATE Thai_CI_AS +')' AS Bay, s.tp, ABS(b.Load) AS mw, ABS(b.Load)/(s.TPRate*0.95)*100 AS PercentUtilization, s.TPRate
        from Bay_Load b
        inner join substation_tp s on b.Sub = s.Sub and b.Bay COLLATE Thai_CI_AS = s.Bay COLLATE Thai_CI_AS
        where b.date = '$last_date'
        and s.tp IS NOT NULL
        and b.Sub = '$substation'";
     */
    $query = "SELECT b.date, b.time, b.Area, b.Substation, RTRIM(b.feeder) +' ('+ s.TransformerCode COLLATE database_default +')' AS Bay, s.TransformerCode, ABS(b.subload) AS mw, ABS(b.subload)/(s.TransformerRate*0.9)*100 AS PercentUtilization, s.TransformerRate TPRate
        from SCADA.dbo.LOAD_$year b
        inner join Substation.dbo.Feeder s
		on b.Substation = s.SubstationCode COLLATE database_default
		and b.Feeder = s.FeederCode COLLATE database_default
        where b.date = '$last_date'
        and s.TransformerCode IN ('TP1','TP2','TP3','TP4','TP5')
        and b.Substation = '$substation'";

    ini_set('max_execution_time', 60);
    $result = mssql_query($query);

	//print $query.'</br>';


    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    /*while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            if($row->Sub == 'Total'){
                $data[$row->Sub][$datetime] = $row->mw;
            }
            else{
                $data[$row->Bay][$datetime] = $row->mw;
            }

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }*/

    $output['name'] = array();
    $output['tprate'] = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            if (!in_array($row->Bay, $output['name'])) {
                array_push($output['name'], $row->Bay);
                $output['tprate'][$row->Bay] = $row->TPRate;
            }
            $datetime = "$row->date $row->time";
            $data[$row->Bay][$datetime] = $row->mw;
            $data2[$row->Bay][$row->time] = $row->mw;
            $dataPercentUT[$row->Bay][$row->time] = $row->PercentUtilization;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["raw"] = $dataPercentUT;

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
        }
    }

    foreach ($dataPercentUT as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['valuesPercent'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['valuesPercent'][$sub][] = null;
            }
        }
    }

    $dbc = mysqli_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql, $DataBaseName_mysql);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $dbc->set_charset('utf8');

    $nameArr = array();
    $labelArr = array();

    mssql_close($conn);
    mysqli_close($dbc);

    /*$output['name'] = $nameArr;
    $output['label'] = $labelArr;*/
    $output['area'] = $area;

    return $output;
}

function get_load_data_tp_monthly($day, $dayStop, $area, $substation)
{
    include "db_connection.php";

    $data = array();
    $data2 = array();
    $dataMin = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    $dayStop = date_create_from_format("d-m-Y", $dayStop)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day);
    $start_date = date("Y-m-d", $day);
    $last_date = date("Y-m-d", $dayStop);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

/*	$query = "SELECT b.Area, b.date, b.substation, RTRIM(b.feeder) COLLATE Thai_CI_AS +' ('+ s.TransformerCode COLLATE Thai_CI_AS +')' AS Bay, s.TransformerCode, MAX(ABS(b.subload)) AS mw, MAX(ABS(b.subload))/(s.TransformerRate*0.85)*100 AS PercentUtilization, s.TransformerRate AS TPRate, MIN(ABS(b.subload)) AS mwMin, MIN(ABS(b.subload))/(s.TransformerRate*0.85)*100 AS PercentUtilizationMin
        from SCADA.dbo.LOAD_$year b inner join Substation.dbo.Feeder s
		on b.Substation = s.SubstationCode COLLATE database_default
		and b.Feeder  = s.FeederCode COLLATE database_default
        where b.date >= '$start_date' and b.date <= '$last_date'
        and s.TransformerCode IN ('TP1','TP2','TP3','TP4','TP5')
        and b.substation = '$substation'
        and s.DistrictCode = '$area'
        group by b.date, b.Area, b.substation, RTRIM(b.feeder) COLLATE Thai_CI_AS +' ('+ s.TransformerCode COLLATE Thai_CI_AS +')', s.TransformerCode, s.TransformerRate
        order by b.substation, s.TransformerCode, b.date";
     */
    $query = "SELECT b.date, b.substation, RTRIM(b.feeder) COLLATE Thai_CI_AS +' ('+ s.TransformerCode COLLATE Thai_CI_AS +')' AS Bay, s.TransformerCode, MAX(ABS(b.subload)) AS mw, MAX(ABS(b.subload))/(s.TransformerRate*0.9)*100 AS PercentUtilization, s.TransformerRate AS TPRate, MIN(ABS(b.subload)) AS mwMin, MIN(ABS(b.subload))/(s.TransformerRate*0.9)*100 AS PercentUtilizationMin
        from SCADA.dbo.LOAD_$year b inner join Substation.dbo.Feeder s
		on b.Substation = s.SubstationCode COLLATE database_default
		and b.Feeder  = s.FeederCode COLLATE database_default
        where b.date >= '$start_date' and b.date <= '$last_date'
        and s.TransformerCode IN ('TP1','TP2','TP3','TP4','TP5')
        and b.substation = '$substation'
        group by b.date, b.substation, RTRIM(b.feeder) COLLATE Thai_CI_AS +' ('+ s.TransformerCode COLLATE Thai_CI_AS +')', s.TransformerCode, s.TransformerRate
        order by b.substation, s.TransformerCode, b.date";


    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    /*while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            if($row->Sub == 'Total'){
                $data[$row->Sub][$datetime] = $row->mw;
            }
            else{
                $data[$row->Bay][$datetime] = $row->mw;
            }

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }*/

    $output['name'] = array();
    $output['tprate'] = array();

    while ($row = mssql_fetch_object($result)) {
        if (!in_array($row->Bay, $output['name'])) {
            array_push($output['name'], $row->Bay);
            $output['tprate'][$row->Bay] = $row->TPRate;
        }
        //$datetime = "$row->date $row->time";
        //$data[$row->Bay][$datetime] = $row->mw;
        $data2[$row->Bay][$row->date] = $row->mw;
        $dataPercentUT[$row->Bay][$row->date] = $row->PercentUtilization;
        $dataMin[$row->Bay][$row->date] = $row->mwMin;
        $dataPercentUTMin[$row->Bay][$row->date] = $row->PercentUtilizationMin;

        /*if (in_array($datetime, $category) === false) {
            $category[] = $datetime;
        }*/
    }

    $output["raw"] = $dataPercentUT;

    $output["categories"] = array();
    while (strtotime($start_date) <= strtotime($last_date)) {
        array_push($output["categories"], $start_date);
        $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
    }

    foreach ($data2 as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }
    }

    foreach ($dataPercentUT as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['valuesPercent'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['valuesPercent'][$sub][] = null;
            }
        }
    }

    foreach ($dataMin as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['valuesmin'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }
    }

    foreach ($dataPercentUTMin as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['valuesPercentMin'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['valuesPercentMin'][$sub][] = null;
            }
        }
    }

    $dbc = mysqli_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql, $DataBaseName_mysql);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $dbc->set_charset('utf8');

    $nameArr = array();
    $labelArr = array();

    mssql_close($conn);
    mysqli_close($dbc);

    /*$output['name'] = $nameArr;
    $output['label'] = $labelArr;*/
    $output['area'] = $area;

    return $output;
}

function get_load_data_province($day, $area, $province)
{
    include "db_connection.php";

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    //$conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database (data.php)");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";
    $year = date("Y", $day);
    $prev_year = date("Y", $day) - 1;
    $yesterday = date("Y-m-d", $day - (60 * 60 * 24));

    $query = "";

    $output['12Area'] = 0;

    if ($area == "Total") {
        $query = "SELECT [date],[time],'Total' AS Sub ,'Total' AS Bay , SUM(subload) as mw
            FROM SCADA.dbo.LOAD_$year
            WHERE feeder = 'PROVINCE'
            AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
            AND date = '$last_date' AND time >= '$last_time'
            GROUP BY [date],[time]
            UNION
            SELECT [date],[time],'Total' AS Sub ,LTRIM(RTRIM(substation)) AS Bay , SUM(subload) as mw
            FROM SCADA.dbo.LOAD_$year
            WHERE feeder = 'PROVINCE'
            AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
            AND date = '$last_date' AND time >= '$last_time'
            GROUP BY [date],[time], substation
            UNION
            SELECT [date],[time],'Yesterday' AS Sub ,'Yesterday' AS Bay , SUM(subload) as mw
            FROM SCADA.dbo.LOAD_$year
            WHERE feeder = 'PROVINCE'
            AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
            AND date = '$yesterday' AND time >= '$last_time'
            GROUP BY [date],[time]
            UNION
            SELECT [date],[time],'Peak' AS Sub ,'Peak' AS Bay , SUM(subload) as mw
            FROM SCADA.dbo.LOAD_$year
            WHERE feeder = 'PROVINCE'
            AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
            AND date = (SELECT [date] FROM
                                    (SELECT top 1 [date],SUM(subload) as Max
                                    FROM SCADA.dbo.LOAD_$year
                                    WHERE feeder = 'PROVINCE'
                                    AND substation IN ('N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3')
                                    AND YEAR([date])='$year'
                                    GROUP BY [date],[time]
                                    ORDER BY Max Desc) as temp)
            AND time >= '$last_time'
            GROUP BY [date],[time]
            ORDER BY [date],[time] ASC";
        $output['12Area'] = 1;
    } else {
        if ($province == "Total") {
            $query = "SELECT [date],[time],'Total' AS Sub ,'Total' AS Bay , subload as mw
				FROM SCADA.dbo.LOAD_$year
				WHERE feeder = 'PROVINCE'
				AND substation = '$area'
                AND date = '$last_date' AND time >= '$last_time'
				UNION
				SELECT [date],[time],LTRIM(RTRIM(substation)) AS Sub ,LTRIM(RTRIM(feeder)) AS Bay , subload as mw
				FROM SCADA.dbo.LOAD_$year
				WHERE feeder <> 'PROVINCE'
				AND feeder <> 'UF'
				AND substation = '$area'
                AND date = '$last_date' AND time >= '$last_time'
				UNION
				SELECT [date],[time],'Yesterday' AS Sub ,'Yesterday' AS Bay , subload as mw
				FROM SCADA.dbo.LOAD_$year
				WHERE feeder = 'PROVINCE'
				AND substation = '$area'
                AND date = '$yesterday' AND time >= '$last_time'
				UNION
				SELECT [date],[time],'Peak' AS Sub ,'Peak' AS Bay , subload as mw
				FROM SCADA.dbo.LOAD_$year
				WHERE feeder = 'PROVINCE'
				AND substation = '$area'
                AND date = (SELECT [date] FROM
										(SELECT top 1 [date],subload as Max
										FROM SCADA.dbo.LOAD_$year
										WHERE feeder = 'PROVINCE'
										AND substation = '$area'
										AND YEAR([date])='$year'
										ORDER BY Max Desc) as temp)
				AND time >= '$last_time'
				ORDER BY [date],[time],Bay ASC";
        } else {
            $query = "SELECT [date],[time],LTRIM(RTRIM(substation)) AS Sub ,LTRIM(RTRIM(feeder)) AS Bay , subload as mw
				FROM SCADA.dbo.LOAD_$year
				WHERE substation = '$area'
				AND feeder='$province'
                AND date = '$last_date' AND time >= '$last_time'
				UNION
				SELECT [date],[time],'Yesterday' AS Sub ,'Yesterday' AS Bay , SUM(subload) as mw
				FROM SCADA.dbo.LOAD_$year
				WHERE substation = '$area'
				AND feeder='$province'
                AND date = '$yesterday' AND time >= '$last_time'
				GROUP BY [date],[time]
				UNION
				SELECT [date],[time],'Peak' AS Sub ,'Peak' AS Bay , subload as mw
				FROM SCADA.dbo.LOAD_$year
				WHERE substation = '$area'
				AND feeder='$province'
                AND date = (SELECT [date] FROM
										(SELECT top 1 [date],subload as Max
										FROM SCADA.dbo.LOAD_$year
										WHERE substation = '$area'
										AND feeder='$province'
										AND YEAR([date])='$year'
										ORDER BY Max Desc) as temp)
				AND time >= '$last_time'
				ORDER BY [date],[time] ASC";
        }
    }
    //echo $query;

    /*$query = sprintf("SELECT date, time, 'Total' AS Sub, 'Total' AS Bay, SUM(Load) AS mw
        FROM Bay_Load
        WHERE Sub IN ('%s_SPPHV', '%s_SPPMV', '%s_VSPPHV', '%s_VSPPMV')
        AND Bay IN ('GAS','BIO','COAL','HYDRO','OIL','OTHER','SOLAR','WASTE','WIND')
        AND date = '$last_date' AND time >= '$last_time'
        GROUP BY date, time",$area,$area,$area,$area);*/

    ini_set('max_execution_time', 120);
    ini_set('mssql.connect_timeout', 120);
    ini_set('mssql.timeout', 120);
    set_time_limit (120);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.<br/>");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    $total = 0;
    $lastDatetime = '';

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Bay][$datetime] = $row->mw;
            $data2[$row->Bay][$row->time] = $row->mw;
            $PeakDate[$row->Bay] = $row->date;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    mssql_free_result($result);

    $label = "Peak (" . $PeakDate['Peak'] . ")";

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    $catIdx = 0;
    foreach ($data2 as $sub => $item) {
        foreach ($output["categories"] as $key => $time) {
            if (array_key_exists($time, $item)) {
                $output['values'][$sub][] = number_format($item[$time], 2, ".", "");
            } else {
                $output['values'][$sub][] = null;
            }
        }
    }

    $nameArr = array();
    $labelArr = array();


    if ($area != "Total") {
        if ($province == 'Total') {
            $query = "SELECT LTRIM(RTRIM(NameInDB)) as Name, LTRIM(RTRIM(NameOfficial)) as FullName FROM SCADA.dbo.PROVINCE_DB WHERE NameInDB IN
				(SELECT LTRIM(RTRIM(feeder COLLATE Thai_CI_AS))
				FROM SCADA.dbo.LOAD_$year
				WHERE feeder <> 'PROVINCE'
				AND substation = '$area'
                AND date = '$last_date' AND time >= '$last_time')";
            $result = mssql_query($query);
            if (!$result) {
                die("Error : " . mssql_get_last_message());
            }
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Name);
                array_push($labelArr, $row->FullName);
            }
            array_push($nameArr, 'Total');
            array_push($labelArr, 'Total');
            array_push($nameArr, 'Peak');
            array_push($labelArr, $label);
            array_push($nameArr, 'Yesterday');
            array_push($labelArr, 'Yesterday');
        } else {
            $query = "SELECT LTRIM(RTRIM(NameInDB)) as Name, LTRIM(RTRIM(NameOfficial)) as FullName FROM SCADA.dbo.PROVINCE_DB WHERE NameInDB IN
				(SELECT LTRIM(RTRIM(feeder COLLATE Thai_CI_AS))
				FROM SCADA.dbo.LOAD_$year
				WHERE feeder <> 'PROVINCE'
				AND substation = '$area'
				and feeder = '$province'
                AND date = '$last_date' AND time >= '$last_time')";
            $result = mssql_query($query);
            while ($row = mssql_fetch_object($result)) {
                array_push($nameArr, $row->Name);
                array_push($labelArr, $row->FullName);
            }
            array_push($nameArr, 'Peak');
            array_push($labelArr, $label);
            array_push($nameArr, 'Yesterday');
            array_push($labelArr, 'Yesterday');
        }
    } else {
        array_push($nameArr, 'N1');
        array_push($labelArr, 'N1');
        array_push($nameArr, 'N2');
        array_push($labelArr, 'N2');
        array_push($nameArr, 'N3');
        array_push($labelArr, 'N3');
        array_push($nameArr, 'NE1');
        array_push($labelArr, 'NE1');
        array_push($nameArr, 'NE2');
        array_push($labelArr, 'NE2');
        array_push($nameArr, 'NE3');
        array_push($labelArr, 'NE3');
        array_push($nameArr, 'C1');
        array_push($labelArr, 'C1');
        array_push($nameArr, 'C2');
        array_push($labelArr, 'C2');
        array_push($nameArr, 'C3');
        array_push($labelArr, 'C3');
        array_push($nameArr, 'S1');
        array_push($labelArr, 'S1');
        array_push($nameArr, 'S2');
        array_push($labelArr, 'S2');
        array_push($nameArr, 'S3');
        array_push($labelArr, 'S3');
        array_push($nameArr, 'Total');
        array_push($labelArr, 'Total');
        array_push($nameArr, 'Peak');
        array_push($labelArr, $label);
        array_push($nameArr, 'Yesterday');
        array_push($labelArr, 'Yesterday');
    }

    mssql_close($conn);
//    mysqli_close($dbc);

    $output['name'] = $nameArr;
    $output['label'] = $labelArr;
    $output['area'] = $area;
    $output['query'] = $query;

    return $output;
}

function get_load_data_spp_vspp_type($day, $area)
{
    include "db_connection.php";

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = sprintf("SELECT date, time, 'Total' AS Sub, 'Total' AS Bay, SUM(Load) AS mw
        FROM Bay_Load
        WHERE Sub IN ('%s_SPPHV', '%s_SPPMV', '%s_VSPPHV', '%s_VSPPMV')
        AND Bay IN ('GAS','BIO','COAL','HYDRO','OIL','OTHER','SOLAR','WASTE','WIND')
        AND date = '$last_date' AND time >= '$last_time'
        GROUP BY date, time
        UNION
        SELECT date, time, 'SPP' AS Sub, Bay, SUM(Load) AS mw
        FROM Bay_Load
        WHERE Sub IN ('%s_SPPHV', '%s_SPPMV')
        AND Bay IN ('GAS','BIO','COAL','HYDRO','OIL','OTHER','SOLAR','WASTE','WIND')
        AND date = '$last_date' AND time >= '$last_time'
        GROUP BY Bay, date, time
        UNION
        SELECT date, time, 'VSPP' AS Sub, Bay, SUM(Load) AS mw
        FROM Bay_Load
        WHERE Sub IN ('%s_VSPPHV', '%s_VSPPMV')
        AND Bay IN ('GAS','BIO','COAL','HYDRO','OIL','OTHER','SOLAR','WASTE','WIND')
        AND date = '$last_date' AND time >= '$last_time'
        GROUP BY Bay, date, time
        ORDER BY Bay, date, time", $area, $area, $area, $area, $area, $area, $area, $area, $area, $area);
    //$output['query'] = $query;

    /*$query = sprintf("SELECT date, time, 'Total' AS Sub, 'Total' AS Bay, SUM(Load) AS mw
        FROM Bay_Load
        WHERE Sub IN ('%s_SPPHV', '%s_SPPMV', '%s_VSPPHV', '%s_VSPPMV')
        AND Bay IN ('GAS','BIO','COAL','HYDRO','OIL','OTHER','SOLAR','WASTE','WIND')
        AND date = '$last_date' AND time >= '$last_time'
        GROUP BY date, time",$area,$area,$area,$area);*/

    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            if ($row->Sub == 'Total') {
                $data[$row->Sub][$datetime] = $row->mw;
            } else {
                $data[$row->Sub . '_' . $row->Bay][$datetime] = $row->mw;
            }

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 96; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }

    /*$query = sprintf("SELECT date, time, '%s SPP' AS Sub, Bay, SUM(Load) AS mw
        FROM Bay_Load
        WHERE Sub IN ('%s_SPPHV', '%s_SPPMV')
        AND Bay IN ('GAS','BIO','COAL','HYDRO','OIL','OTHER','SOLAR','WASTE','WIND')
        AND date = '$last_date' AND time >= '$last_time'
        GROUP BY Bay, date, time
        ORDER BY Bay, date, time",$area, $area, $area);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if(mssql_num_rows($result) <= 0){
        $output['available'] = 1;
    }else{
        $output['available'] = 0;
    }
    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Sub][$datetime] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }
    foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 96; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }*/

    mssql_close($conn);
    $labelList = array('BIO', 'COAL', 'GAS', 'HYDRO', 'OIL', 'SOLAR', 'WASTE', 'WIND', 'OTHER');
    $output['name'] = array();
    foreach ($labelList as $value) {
        array_push($output['name'], 'SPP_' . $value);
    }
    foreach ($labelList as $value) {
        array_push($output['name'], 'VSPP_' . $value);
    }
    $output['label'] = $output['name'];
    $output['area'] = $area;

    return $output;
}

function get_load_data_spp_vspp($day, $area)
{
    include "db_connection.php";

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    // $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");
    $conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $year = date("Y", $day);
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    if ($area == "Total") {
        $query = "SELECT date, time, 'Total' AS Sub, SUM(subLoad) AS mw
			FROM SCADA.dbo.LOAD_$year
			WHERE (Substation = '11SH' OR Substation = '11SM' OR Substation = '11VM' OR Substation = '11VM'
			OR Substation = '12SH' OR Substation = '12SM' OR Substation = '12VH' OR Substation = '12VM'
			OR Substation = '13SH' OR Substation = '13SM' OR Substation = '13VH' OR Substation = '13VM'
			OR Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'
			OR Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'
			OR Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'
			OR Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'
			OR Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'
			OR Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'
			OR Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'
			OR Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'
			OR Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM')
			AND date = '$last_date' AND time >= '$last_time'
			GROUP BY date, time
			UNION
			SELECT date, time, LEFT(Substation,2) as Sub, SUM(subload) AS mw
			FROM SCADA.dbo.LOAD_$year
			WHERE (Substation = '11SH' OR Substation = '11SM' OR Substation = '11VM' OR Substation = '11VM'
			OR Substation = '12SH' OR Substation = '12SM' OR Substation = '12VH' OR Substation = '12VM'
			OR Substation = '13SH' OR Substation = '13SM' OR Substation = '13VH' OR Substation = '13VM'
			OR Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'
			OR Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'
			OR Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'
			OR Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'
			OR Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'
			OR Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'
			OR Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'
			OR Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'
			OR Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM')
			AND date = '$last_date' AND time >= '$last_time'
			GROUP BY date, time, LEFT(Substation,2)
			ORDER BY Sub, date, time";
    } else {
        switch ($area) {
            case "N1":
                $where = "Substation = '11SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'";
                break;
            case "N2":
                $where = "Substation = '12SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'";
                break;
            case "N3":
                $where = "Substation = '13SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'";
                break;
            case "NE1":
                $where = "Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'";
                break;
            case "NE2":
                $where = "Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'";
                break;
            case "NE3":
                $where = "Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'";
                break;
            case "C1":
                $where = "Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'";
                break;
            case "C2":
                $where = "Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'";
                break;
            case "C3":
                $where = "Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'";
                break;
            case "S1":
                $where = "Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'";
                break;
            case "S2":
                $where = "Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'";
                break;
            case "S3":
                $where = "Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM'";
                break;
        }
        $query = sprintf("SELECT date, time, 'Total' AS Sub, SUM(subLoad) AS mw
			FROM SCADA.dbo.LOAD_$year
			WHERE (%s)
			AND date = '$last_date' AND time >= '$last_time'
			GROUP BY date, time
			UNION
			SELECT date, time, LEFT(Substation,2) as Sub, SUM(subload) AS mw
			FROM SCADA.dbo.LOAD_$year
			WHERE (%s)
			AND date = '$last_date' AND time >= '$last_time'
			GROUP BY date, time, LEFT(Substation,2)
			ORDER BY Sub, date, time", $where, $where);
    }

	//printf("%s\n",$query);
	//ini_set('max_execution_time', 60);
    $result = mssql_query($query);

    if ($result === false) {
        die("Error sending query to SQL Server database.");

    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';
    $nameArr = array();
    $labelArr = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Sub][$datetime] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 96; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }

    mssql_close($conn);

    switch ($area) {
        case "Total":
            array_push($nameArr, '11');
            array_push($labelArr, 'N1');
            array_push($nameArr, '12');
            array_push($labelArr, 'N2');
            array_push($nameArr, '13');
            array_push($labelArr, 'N3');
            array_push($nameArr, '21');
            array_push($labelArr, 'NE1');
            array_push($nameArr, '22');
            array_push($labelArr, 'NE2');
            array_push($nameArr, '23');
            array_push($labelArr, 'NE3');
            array_push($nameArr, '31');
            array_push($labelArr, 'C1');
            array_push($nameArr, '32');
            array_push($labelArr, 'C2');
            array_push($nameArr, '33');
            array_push($labelArr, 'C3');
            array_push($nameArr, '41');
            array_push($labelArr, 'S1');
            array_push($nameArr, '42');
            array_push($labelArr, 'S2');
            array_push($nameArr, '43');
            array_push($labelArr, 'S3');
            array_push($nameArr, 'Total');
            array_push($labelArr, 'Total');
            break;
        case "N2":
            $where = "Substation = '12SH' OR Substation = '12SM' OR Substation = '12VH' OR Substation = '12VM'";
            break;
        case "N3":
            $where = "Substation = '13SH' OR Substation = '11SM' OR Substation = '11VH' OR Substation = '11VM'";
            break;
        case "NE1":
            $where = "Substation = '21SH' OR Substation = '21SM' OR Substation = '21VH' OR Substation = '21VM'";
            break;
        case "NE2":
            $where = "Substation = '22SH' OR Substation = '22SM' OR Substation = '22VH' OR Substation = '22VM'";
            break;
        case "NE3":
            $where = "Substation = '23SH' OR Substation = '23SM' OR Substation = '23VH' OR Substation = '23VM'";
            break;
        case "C1":
            $where = "Substation = '31SH' OR Substation = '31SM' OR Substation = '31VH' OR Substation = '31VM'";
            break;
        case "C2":
            $where = "Substation = '32SH' OR Substation = '32SM' OR Substation = '32VH' OR Substation = '32VM'";
            break;
        case "C3":
            $where = "Substation = '33SH' OR Substation = '33SM' OR Substation = '33VH' OR Substation = '33VM'";
            break;
        case "S1":
            $where = "Substation = '41SH' OR Substation = '41SM' OR Substation = '41VH' OR Substation = '41VM'";
            break;
        case "S2":
            $where = "Substation = '42SH' OR Substation = '42SM' OR Substation = '42VH' OR Substation = '42VM'";
            break;
        case "S3":
            $where = "Substation = '43SH' OR Substation = '43SM' OR Substation = '43VH' OR Substation = '43VM'";
            break;
    }


    if ($area == "Total") {
        $output['name'] = $nameArr;
        $output['label'] = $labelArr;
		//$output['name'] = array($area.'_SPPHV', $area.'_SPPMV', $area.'_VSPPHV', $area.'_VSPPMV');
		//$output['label'] = array('SPPHV', 'SPPMV', 'VSPPHV', 'VSPPMV');
        $output['area'] = $area;
    }
    return $output;
}

function get_load_data_14province_total($day)
{
    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    $day = strtotime($day);
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT 'S1' AS area, b.date date, b.time time, SUM(ABS(b.Load)) AS mw
        FROM Bay_Load b
        INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder
        WHERE b.date = '$last_date' and b.time >= '$last_time'
        AND f.SubstationID IN ('CPA', 'CPB', 'LSA', 'TSE', 'RNA', 'RNB')
        GROUP BY b.date, b.time
        UNION
        SELECT t.Area area, t.date date, t.time time, t.MW mw FROM dbo.Total_MW t WHERE date = '$last_date' and time >= '$last_time' AND Area IN ('S2','S3')";
    $result = mssql_query($query);

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) != '5') {
            $datetime = "$row->date $row->time";
            $data[$row->area][$datetime] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }

    //foreach ($category as $datetime) {
        //if (date('Y-m-d') == substr($datetime, 0, 10)) {
        //$output['categories'][] = date('H:i', strtotime($datetime));
        //}
        //else {
        //    $output['categories'][] = 'เมื่อวาน ' . date('H:i', strtotime($datetime));
        //}
    //}
    $output["categories"] = array(
        "00:00", "00:30", "01:00", "01:30", "02:00", "02:30", "03:00", "03:30", "04:00", "04:30",
        "05:00", "05:30", "06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00",
        "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
        "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"
    );

    foreach ($data as $area => $item) {
        $count = 0;

        foreach ($item as $key => $value) {
            $output['values'][$area][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 48; $i > $count; $i--) {
            $output['values'][$area][] = null;
        }
    }

    return $output;
}

function get_load_data_14province($day)
{
    include "db_connection.php";

    $mySQLconn = mysql_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql) or die("Unable to connect to the database");
    mysql_select_db($DataBaseName_mysql, $mySQLconn) or die("can not select the database $DataBaseName_mysql");
    mysql_query("SET NAMES UTF8");
    $sql = "SELECT * FROM province WHERE ProvinceID IN (5,6,7) ORDER BY ProvinceID";
    //print $sql.'<br/>';
    //$res = mysql_query($sql,$conn);

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    /*while($row = mysql_fetch_array($res))
    {
        $output['ProvinceID'][] = $row['ProvinceID'];
        $output['ProvinceName'][] = $row['ProvinceName'];
    }*/

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    $query = "SELECT DISTINCT ProvinceID FROM Load_formula l INNER JOIN substation s ON l.SubstationID = s.SubstationID";

    $result = mssql_query($query);

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    $provinceID = array();

    while ($row = mssql_fetch_object($result)) {
        $provinceID[] = $row->ProvinceID;
    }

    $sql = "SELECT * FROM province WHERE ProvinceID IN (" . implode(',', $provinceID) . ") ORDER BY ProvinceID";
    $res = mysql_query($sql, $mySQLconn);

    while ($row = mysql_fetch_array($res)) {
        $output['ProvinceID'][] = $row['ProvinceID'];
        $output['ProvinceName'][] = $row['ProvinceName'];
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT date, time, ProvinceID AS Sub, SUM(mw) mw
        FROM
            (SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load)) mw
            FROM Bay_Load b
            INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 0
            LEFT JOIN substation s ON f.SubstationID = s.SubstationID
            WHERE date = '$last_date' and time >= '$last_time'
            GROUP BY b.date, b.time, s.ProvinceID
            UNION
            SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load))*(-1) mw
            FROM Bay_Load b
            INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 1
            LEFT JOIN substation s ON f.SubstationID = s.SubstationID
            WHERE date = '$last_date' and time >= '$last_time'
            GROUP BY b.date, b.time, s.ProvinceID) AS provinceSum
        GROUP BY date, time, ProvinceID";

    /*$query = "SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load)) mw
        FROM Bay_Load b
        INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 0
        LEFT JOIN substation s ON f.SubstationID = s.SubstationID
        WHERE date = '$last_date' and time >= '$last_time'
        GROUP BY b.date, b.time, s.ProvinceID
        UNION
        SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load))*(-1) mw
        FROM Bay_Load b
        INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 1
        LEFT JOIN substation s ON f.SubstationID = s.SubstationID
        WHERE date = '$last_date' and time >= '$last_time'
        GROUP BY b.date, b.time, s.ProvinceID";

    $query = "SELECT date, time, 0 AS Sub, SUM(mw) mw
        FROM (".$query.") AS provinceSum GROUP BY date, time
        UNION
        SELECT date, time, ProvinceID AS Sub, SUM(mw) mw
        FROM (".$query.") AS provinceSum GROUP BY date, time, ProvinceID";*/
    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Sub][$datetime] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }
    //$output['debug'][] = $data;
    //$data['total'][$datetime] = $total;
    //print_r($data['total']);

    //foreach ($category as $datetime) {
        //if (date('Y-m-d') == substr($datetime, 0, 10)) {
        //$output['categories'][] = date('H:i', strtotime($datetime));
        //}
        //else {
        //    $output['categories'][] = 'เมื่อวาน ' . date('H:i', strtotime($datetime));
        //}
    //}
    $output["categories"] = array(
        "00:00", "00:30", "01:00", "01:30", "02:00", "02:30", "03:00", "03:30", "04:00", "04:30",
        "05:00", "05:30", "06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00",
        "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
        "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"
    );

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 96; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }

    mysql_close();
    mssql_close($conn);

    $output["base"] = array(1828.3117264631, 1804.25177173373, 1785.66913389444, 1770.01731675476, 1752.14427580873, 1738.2467741131, 1725.33486545913, 1711.44660410119, 1696.59595108889, 1691.06498785833, 1682.84429767698, 1672.61155029722, 1663.29057427381, 1661.12415471825, 1655.44949528294, 1649.38825483968, 1649.89317750198, 1655.45786084603, 1663.49759041071, 1677.46067849048, 1693.99912334802, 1728.63792560873, 1760.02644079444, 1806.59012158175, 1841.03603720516, 1830.2783734381, 1783.85632925913, 1738.249436825, 1695.63196769921, 1679.80143286508, 1671.79941775476, 1682.78312681825, 1727.94711882183, 1792.04089403968, 1842.84171079206, 1893.70890792937, 1908.99237153452, 1927.86513135198, 1950.40973263413, 1980.05215034286, 1999.66124193095, 2016.17068076984, 2037.84245588611, 2046.17055903294, 2053.1417175254, 2057.84595544444, 2055.36885067778, 2036.24481328254, 1988.57365227302, 1962.77220009008, 1970.29358437381, 1975.89840852302, 1998.53173416746, 2053.63666181151, 2071.14211636111, 2073.20594184603, 2070.00731684365, 2059.99176510754, 2052.5817662377, 2040.83036111071, 2021.98235317063, 2015.57619790357, 2000.59444650992, 1984.82477031548, 1961.60178357937, 1948.11902115595, 1932.97122473214, 1910.24333680992, 1879.09353016151, 1865.53398839444, 1866.20342616865, 1878.63990430516, 1901.71527810317, 1961.98262450476, 2059.758198125, 2178.75569886944, 2240.29826776865, 2252.96881153373, 2248.18256727063, 2238.23866986032, 2230.92596710437, 2219.59609523532, 2207.07589738333, 2183.36437869206, 2159.45911515675, 2130.6624894254, 2103.80339899008, 2072.55612618968, 2055.92975265675, 2063.82023738095, 2058.33844826032, 2026.50448394048, 1987.92020127897, 1951.0908488, 1920.22601939008, 1892.95608200754);

    return $output;
}

function get_load_data_1province($day, $pvid)
{
    include "db_connection.php";

    $mySQLconn = mysql_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql) or die("Unable to connect to the database");
    mysql_select_db($DataBaseName_mysql, $mySQLconn) or die("can not select the database $DataBaseName_mysql");
    mysql_query("SET NAMES UTF8");
    $sql = "SELECT * FROM province WHERE ProvinceID IN ($pvid) ORDER BY ProvinceID";
    //print $sql.'<br/>';
    $res = mysql_query($sql, $mySQLconn);

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();
    $subInProvince = array();

    while ($row = mysql_fetch_array($res)) {
        $output['ProvinceID'][] = $row['ProvinceID'];
        $output['ProvinceName'][] = $row['ProvinceName'];
    }

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    $query = "SELECT DISTINCT ProvinceID FROM Load_formula l INNER JOIN substation s ON l.SubstationID = s.SubstationID";

    $result = mssql_query($query);

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    /*$provinceID = array();

    while ($row = mssql_fetch_object($result)) {
        $provinceID[] = $row->ProvinceID;
    }

    $sql = "SELECT * FROM province WHERE ProvinceID IN (".implode(',', $provinceID).") ORDER BY ProvinceID";
    $res = mysql_query($sql,$mySQLconn);

    while($row = mysql_fetch_array($res))
    {
        $output['ProvinceID'][] = $row['ProvinceID'];
        $output['ProvinceName'][] = $row['ProvinceName'];
    }*/

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT date, time, ProvinceID AS Sub, SUM(mw) mw
        FROM
            (SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load)) mw
            FROM Bay_Load b
            INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 0
            LEFT JOIN substation s ON f.SubstationID = s.SubstationID
            WHERE date = '$last_date' and time >= '$last_time' AND s.ProvinceID = $pvid
            GROUP BY b.date, b.time, s.ProvinceID
            UNION
            SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load))*(-1) mw
            FROM Bay_Load b
            INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 1
            LEFT JOIN substation s ON f.SubstationID = s.SubstationID
            WHERE date = '$last_date' and time >= '$last_time' AND s.ProvinceID = $pvid
            GROUP BY b.date, b.time, s.ProvinceID) AS provinceSum
        GROUP BY date, time, ProvinceID";

    /*$query = "SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load)) mw
        FROM Bay_Load b
        INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 0
        LEFT JOIN substation s ON f.SubstationID = s.SubstationID
        WHERE date = '$last_date' and time >= '$last_time'
        GROUP BY b.date, b.time, s.ProvinceID
        UNION
        SELECT b.date, b.time, s.ProvinceID, SUM(ABS(b.Load))*(-1) mw
        FROM Bay_Load b
        INNER JOIN load_formula f ON b.Sub = f.FeederLocation AND b.Bay = f.Feeder AND f.Operation = 1
        LEFT JOIN substation s ON f.SubstationID = s.SubstationID
        WHERE date = '$last_date' and time >= '$last_time'
        GROUP BY b.date, b.time, s.ProvinceID";

    $query = "SELECT date, time, 0 AS Sub, SUM(mw) mw
        FROM (".$query.") AS provinceSum GROUP BY date, time
        UNION
        SELECT date, time, ProvinceID AS Sub, SUM(mw) mw
        FROM (".$query.") AS provinceSum GROUP BY date, time, ProvinceID";*/
    ini_set('max_execution_time', 60);
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    if (mssql_num_rows($result) <= 0) {
        $output['available'] = 1;
    } else {
        $output['available'] = 0;
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) == '0' or substr($row->time, -1) == '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Sub][$datetime] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }
    //$output['debug'][] = $data;
    //$data['total'][$datetime] = $total;
    //print_r($data['total']);

    //foreach ($category as $datetime) {
        //if (date('Y-m-d') == substr($datetime, 0, 10)) {
        //$output['categories'][] = date('H:i', strtotime($datetime));
        //}
        //else {
        //    $output['categories'][] = 'เมื่อวาน ' . date('H:i', strtotime($datetime));
        //}
    //}
    $output["categories"] = array(
        "00:00", "00:30", "01:00", "01:30", "02:00", "02:30", "03:00", "03:30", "04:00", "04:30",
        "05:00", "05:30", "06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00",
        "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
        "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"
    );

    $output["categories"] = array('00:00', '00:15', '00:30', '00:45', '01:00', '01:15', '01:30', '01:45', '02:00', '02:15', '02:30', '02:45', '03:00', '03:15', '03:30', '03:45', '04:00', '04:15', '04:30', '04:45', '05:00', '05:15', '05:30', '05:45', '06:00', '06:15', '06:30', '06:45', '07:00', '07:15', '07:30', '07:45', '08:00', '08:15', '08:30', '08:45', '09:00', '09:15', '09:30', '09:45', '10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '11:45', '12:00', '12:15', '12:30', '12:45', '13:00', '13:15', '13:30', '13:45', '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30', '16:45', '17:00', '17:15', '17:30', '17:45', '18:00', '18:15', '18:30', '18:45', '19:00', '19:15', '19:30', '19:45', '20:00', '20:15', '20:30', '20:45', '21:00', '21:15', '21:30', '21:45', '22:00', '22:15', '22:30', '22:45', '23:00', '23:15', '23:30', '23:45');

    foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 96; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }

    mysql_close();
    mssql_close($conn);

    $baseLoad = array();
    /*$baseLoadTmp = array(1814.1692102,1790.3729217,1772.0714429,1757.6954948,1739.2992028,1725.8036351,1713.1578992,1699.3870078,1684.2741812,1679.1818886,1671.1954896,1660.5719436,1651.6433931,1649.3040336,1643.6759629,1637.7686732,1637.5030703,1642.9771791,1651.2111907,1664.9720066,1681.2228396,1716.1836205,1746.7896024,1793.3400761,1827.9172022,1817.0189148,1770.913437,1726.3251828,1682.3475006,1667.9499979,1659.4644447,1669.7162487,1715.2975007,1790.4183966,1841.0778241,1891.5905283,1906.9577903,1924.8418279,1946.797151,1975.2297664,1996.6959915,2012.7737753,2035.0762691,2043.3252235,2050.8390922,2053.5314276,2050.5035948,2032.5200151,1981.5276996,1954.2279827,1962.4000324,1967.7940987,1989.2682325,2044.5182755,2061.1001261,2062.5617244,2059.9026426,2050.01928,2042.839403,2031.3408125,2013.2231441,2003.5928814,1989.1912556,1973.8133096,1950.0573648,1940.3836316,1925.7999981,1904.3584369,1873.6496587,1858.6446272,1858.6993971,1870.0100197,1890.3600196,1946.9549652,2045.9526643,2165.1990599,2224.9713661,2236.9655725,2231.712514,2215.5171709,2207.4360323,2195.8854368,2183.791029,2160.1541454,2136.3783997,2108.5805611,2081.4856808,2050.7725737,2033.3665686,2042.6896398,2037.1347574,2004.0284775,1966.9031552,1930.3125495,1899.083914,1871.9530602);
    array_push($baseLoad, $baseLoadTmp);*/

    $baseLoadTmp = array(96.1145324, 96.3352288, 93.3514748, 92.514745, 92.0587154, 91.6500976, 91.0712096, 88.9879884, 87.4674616, 88.0481898, 88.449603, 87.7786926, 87.8820972, 87.5267454, 86.3412156, 86.1904422, 85.9259996, 87.2232444, 89.099692, 90.3392156, 90.3433204, 92.6721032, 96.8629822, 103.7080696, 107.127334, 107.6061544, 102.8120538, 100.3729248, 95.2486276, 94.0696918, 92.8427874, 90.5331302, 92.6126806, 95.345826, 97.414246, 104.873926, 100.919823, 101.0160092, 102.336747, 105.2455358, 104.37581, 108.6038954, 109.3522722, 108.8169948, 109.1568766, 106.6314978, 106.7875, 104.0571072, 101.5978628, 98.639163, 104.2719672, 102.631019, 102.2709038, 103.7002346, 104.7553274, 104.4251656, 105.7416064, 103.9340456, 105.3642356, 105.5457598, 103.6113562, 102.258752, 100.766794, 101.593595, 99.9687872, 99.6598838, 100.489422, 97.259991, 96.3125514, 95.8264612, 96.8529376, 100.4991986, 102.4970676, 104.7402394, 108.3409736, 117.2616874, 126.4865158, 123.2034528, 122.6300178, 122.1656662, 121.5512736, 120.3907432, 119.61619, 118.7093668, 116.810828, 115.149183, 112.1984306, 109.9598412, 110.498996, 112.5272756, 109.9616336, 107.8709954, 104.5942638, 104.6118156, 101.4099888, 100.8463598);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(43.2764757, 42.9517471, 42.4535058, 42.1881516, 41.7533817, 41.5319735, 41.2314853, 41.156813, 40.9602789, 39.7683767, 39.9186043, 39.7506565, 39.205735, 39.4190695, 39.4650701, 39.1242156, 39.4936319, 39.7897096, 39.0536394, 39.7761254, 40.5812041, 41.0920262, 41.6895634, 42.5451921, 42.883312, 43.2417932, 42.9425082, 42.1089341, 39.8706335, 40.4439667, 40.2922228, 40.4926202, 40.8247037, 41.9669769, 42.2323597, 42.8586892, 43.737668, 44.2853741, 44.4757694, 44.594853, 44.4202171, 43.9826367, 44.4795242, 44.3339, 44.4260757, 44.4920636, 44.5902611, 44.0602558, 42.9916614, 43.2134636, 43.4472132, 43.6002132, 44.3071098, 45.0755465, 45.3958655, 44.6582211, 45.061301, 45.4835227, 44.4268986, 43.938249, 43.9753886, 44.360177, 44.2125898, 43.803047, 43.6379546, 44.2355606, 43.9861446, 42.9998834, 42.3678699, 42.0088453, 41.2569353, 40.122824, 39.0245586, 39.2155236, 39.8572378, 41.6654735, 43.5075346, 44.2344521, 44.3296915, 44.2606753, 43.889646, 43.8230228, 43.5849117, 43.1232902, 42.8013772, 42.4214699, 42.0308298, 41.8489701, 42.6595693, 43.8713598, 45.1877502, 45.3309563, 45.0039078, 44.5769711, 44.2307114, 43.8412642);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(210.753001571429, 207.548027714286, 207.257681, 204.245075571429, 202.635978714286, 200.723318571429, 199.286977428571, 197.737620142857, 196.707524, 196.189826, 194.425368571429, 193.07974, 190.158463857143, 191.825651857143, 191.574916285714, 191.540551428571, 192.078794571429, 193.064688857143, 195.056776285714, 197.078309857143, 199.371838428571, 203.934384714286, 208.122592, 217.375433142857, 222.165505285714, 218.986206571429, 209.473010428571, 201.146901, 196.682811571429, 193.062966142857, 192.130154571429, 192.904844857143, 197.198736285714, 205.884755428571, 213.315691714286, 220.081494857143, 212.754115142857, 212.396910571429, 211.803788428571, 213.790720142857, 215.140415714286, 216.099591714286, 217.899486, 218.697939285714, 217.335443714286, 219.979743, 218.694799, 216.163526571429, 209.305160428571, 206.848293142857, 208.183696857143, 210.336394428571, 214.474296428571, 223.055045714286, 225.788676, 225.546119857143, 225.656517571429, 225.968347571429, 224.557493857143, 223.591120285714, 222.157322142857, 220.698187428571, 218.928348857143, 215.382374857143, 211.772439857143, 210.081494714286, 207.624316857143, 204.076809857143, 199.326988714286, 196.332883, 198.244119571429, 201.039145285714, 206.373367714286, 211.931093571429, 221.224753, 235.844379, 245.509072571429, 250.685697714286, 250.698767142857, 252.488861571429, 252.578106857143, 250.985732571429, 249.352376, 245.680562714286, 242.758338142857, 239.511999714286, 235.882355142857, 229.972110428571, 228.559695142857, 236.076896714286, 237.850172571429, 235.051156857143, 229.679990142857, 224.335826, 221.418919142857, 218.368343571429);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(305.1539193, 302.0076486, 298.1419178, 296.0903057, 293.1842413, 290.5020292, 287.6423541, 286.0062015, 283.260574, 283.6224947, 281.6658188, 279.1984821, 279.3553588, 277.9654092, 277.4484416, 275.6758198, 274.6554274, 275.7649441, 277.5725923, 279.5751173, 281.5682114, 286.6658333, 291.0350919, 297.9523784, 304.9820231, 306.4162001, 301.3818766, 295.6043533, 289.7324201, 286.9538101, 285.7400593, 291.6906031, 305.1908877, 314.1664688, 323.8530155, 331.2449023, 334.5945468, 338.5562155, 342.8728597, 348.4322813, 352.7436329, 353.2557762, 355.5560983, 357.526364, 358.8814738, 359.8227939, 359.7621644, 356.3763245, 351.8937992, 347.6980237, 348.6984257, 349.6394298, 353.395377, 362.4714762, 367.2891356, 368.5435676, 362.9886949, 358.7413477, 357.1936473, 357.3250042, 352.8379828, 356.0733851, 353.4776924, 351.6131126, 349.2006526, 348.0745118, 345.3312367, 346.8887406, 337.8493924, 331.897866, 329.1528398, 329.3605281, 329.9981806, 338.8870263, 347.7798844, 362.4105756, 369.5321414, 372.8245621, 373.4078643, 370.8701673, 369.0665668, 368.0660557, 366.5099423, 363.306318, 360.8004158, 355.6150303, 352.6002733, 347.5675582, 346.4803249, 347.9869981, 346.575352, 342.1334434, 335.3676159, 328.1511032, 322.8015206, 317.6047471);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(53.8721023, 53.112399, 52.7590423, 52.1727298, 51.1592872, 51.0151494, 50.5482879, 50.1416663, 50.0143974, 49.8382556, 49.6942475, 49.4116907, 49.2951369, 49.2192054, 49.1237946, 48.6851194, 48.5431053, 48.8461858, 49.3082319, 49.7106691, 50.3161593, 51.5249859, 52.7904775, 54.1053365, 55.1127368, 54.4572835, 52.6305842, 51.0671418, 49.5588858, 49.6067932, 49.3764818, 49.5044057, 51.405116, 54.2783101, 55.9920595, 56.8361975, 57.6158805, 57.9240979, 58.4484552, 59.1698469, 60.1838094, 60.3102069, 60.4687796, 60.2505988, 60.2633024, 60.1505398, 59.7751528, 59.2256483, 56.905409, 56.1895133, 56.6724493, 56.7332053, 57.6576678, 59.4790882, 59.5095577, 59.701985, 59.8522757, 59.6471651, 59.6581076, 59.3157375, 58.822683, 58.102228, 58.0895988, 58.1113789, 57.9998305, 57.536699, 57.3862738, 55.908101, 54.8715884, 55.1235872, 55.3122051, 55.330421, 56.0432194, 57.2947967, 59.3709123, 62.7130954, 65.5689789, 66.9317371, 67.4055245, 67.3422255, 67.2587466, 66.9048082, 66.3950328, 65.3259688, 64.7207807, 64.1311869, 62.6799831, 61.872146, 60.9924173, 60.583537, 60.0821445, 59.0725984, 58.0575915, 56.6332123, 55.7459859, 54.8018637);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(288.4499613, 285.3068333, 283.3245076, 282.1984093, 280.6544602, 278.8832028, 277.5682814, 276.3508158, 275.014002, 273.967381, 273.141327, 272.4981382, 271.4485248, 270.6299987, 270.058832, 269.3706479, 269.2729986, 269.2515596, 269.282248, 269.5017295, 270.3940357, 271.9825879, 273.2917051, 275.0632296, 276.8793287, 278.2952832, 276.975393, 275.8306725, 274.699599, 275.3856705, 275.4550785, 277.7912052, 282.6381918, 289.1271646, 293.6101758, 298.3511794, 301.9448963, 301.8291048, 304.7331331, 309.4468605, 311.7129437, 315.058295, 316.9854784, 317.4320045, 317.5663678, 318.3177278, 318.4328098, 318.172016, 315.7846904, 313.686591, 312.8416731, 312.6217102, 313.3481934, 315.7053071, 316.2489903, 317.7160711, 317.8510014, 318.7908741, 318.7448582, 318.0449772, 318.2154787, 316.7229563, 316.0330603, 315.2565793, 314.3137983, 312.2519312, 311.5390631, 309.7352233, 309.3762224, 308.3479549, 307.6003395, 307.5433457, 307.3900791, 309.0407366, 313.1601929, 320.4574872, 323.8572237, 325.4917508, 325.6525669, 325.8260317, 325.1409551, 324.2702984, 322.7966144, 321.8350124, 320.1578695, 317.7611458, 315.8743179, 314.106223, 311.4097222, 308.3033768, 306.8277, 304.4501753, 301.4631769, 298.7969824, 295.4785122, 292.9341992);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(72.348671, 70.7620575, 69.5246067, 68.6311519, 67.5617622, 66.7283464, 66.372047, 65.5322341, 64.7669775, 64.3009352, 63.5711118, 63.1124508, 63.07874, 62.5265747, 62.0465057, 61.6756892, 61.4483264, 61.9630903, 62.003691, 62.5238684, 62.7433569, 63.6983267, 64.7231791, 66.965305, 69.4483253, 70.6545271, 69.7364671, 68.4124012, 67.0878445, 65.5920281, 64.6614167, 64.2736221, 66.2170274, 69.2086618, 71.2202269, 73.5494584, 74.3132383, 75.3181595, 76.9901576, 77.7514762, 77.7605805, 79.1454236, 78.6198331, 78.479577, 79.8720477, 80.1503447, 80.0361716, 79.1806102, 77.4837606, 77.1195865, 76.8257874, 77.7332682, 78.4960634, 80.2140753, 80.1151581, 79.6493603, 80.7859255, 81.2450784, 80.7736215, 81.0319877, 80.6749512, 80.3051172, 79.8592522, 79.0529031, 78.2226873, 78.672244, 78.2266245, 77.4933559, 75.9244587, 76.080216, 76.4488193, 77.4352859, 79.1466539, 82.0000005, 86.8634354, 92.3164368, 95.3009349, 96.6542816, 96.7765744, 95.7965062, 95.5802167, 94.2490159, 92.8179133, 91.8686029, 89.9325787, 88.0868605, 86.6729829, 85.2010331, 83.5843991, 84.1887301, 84.4520187, 82.6104827, 79.6707679, 77.5142713, 75.9707183, 74.4517724);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(97.5488633, 96.524387, 95.797575, 94.8455586, 93.8181748, 92.9555238, 92.3204308, 91.5018584, 90.0791525, 89.8949486, 89.4291377, 88.9714265, 88.4042509, 88.2004713, 87.6721607, 87.5734896, 87.5469203, 87.5007785, 87.5617574, 87.8637641, 88.5811246, 90.7698633, 92.1930766, 94.631679, 97.8589601, 98.0382591, 95.3082004, 91.7071371, 89.1760867, 87.82519, 87.0341229, 87.6765097, 91.9471232, 98.1321444, 100.0750851, 102.816316, 104.1629703, 105.6023622, 107.2321109, 108.7428274, 110.9875136, 112.1705351, 113.8298425, 113.972997, 113.2133442, 112.9506309, 112.4116392, 110.1387594, 104.4491382, 102.1486489, 102.647314, 102.0482529, 105.2717286, 110.985729, 111.6877135, 112.0787296, 112.322351, 111.9663713, 111.6954163, 110.1707534, 108.9630717, 109.1633155, 107.719234, 106.3802832, 104.4799749, 104.0856921, 103.9830769, 102.3966772, 100.3666718, 99.3664542, 98.7115519, 100.2646664, 101.6258635, 106.1650612, 111.3513021, 117.8536272, 120.4658156, 120.4949384, 120.4223991, 119.6387921, 118.8137859, 117.5254562, 115.475124, 112.7636906, 111.1962198, 108.9815823, 106.4891053, 104.7975405, 104.9854296, 105.5877375, 105.796201, 104.9633563, 102.4438383, 100.6376796, 98.6675659, 96.509192);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(49.5014681, 47.1759294, 46.005054, 45.4185567, 44.622042, 43.8874524, 43.644556, 43.5295391, 42.8255267, 42.989064, 42.8026327, 42.4083739, 41.9043671, 41.7027338, 41.7991819, 42.5711041, 42.4903452, 42.8986061, 43.1231209, 44.5271239, 45.9623111, 48.3241743, 50.3198631, 51.7868075, 53.474439, 51.0965776, 49.236874, 46.9633223, 44.7082235, 43.4550068, 42.4706493, 42.5313269, 43.3129205, 45.619518, 47.9762084, 46.0063827, 47.6463267, 48.0916591, 48.8893394, 50.4084397, 51.1427925, 51.556235, 57.9097455, 59.0628924, 60.7625816, 61.265976, 62.2730722, 62.0275408, 59.1707004, 57.3947434, 57.0220768, 57.0827026, 57.9703949, 60.9031061, 61.6431036, 61.3651272, 61.759225, 61.2116576, 61.2026532, 59.7780266, 58.1021905, 56.7810882, 55.9561088, 54.8562931, 52.9948841, 51.9205916, 51.1618771, 50.181207, 48.8757542, 50.8645777, 52.6996815, 53.5763507, 55.0226022, 62.7374911, 73.8140823, 84.130108, 86.5261468, 86.2896917, 84.7547333, 82.6086521, 83.9408123, 83.7119983, 83.42093, 82.2471336, 79.7038281, 77.9224847, 77.1040566, 75.3310878, 73.2307484, 71.7782495, 71.5196949, 63.9168358, 63.4003134, 59.4359338, 58.1890552, 57.5399811);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(56.985339625, 56.203199875, 55.46320775, 54.74394575, 54.00678625, 53.504551375, 53.006564875, 52.378536125, 51.986667, 51.687446625, 51.11699575, 50.909189875, 50.53184275, 50.58818675, 50.276913875, 50.2547675, 50.576315375, 51.1446235, 51.838545125, 52.8614195, 54.538571375, 57.47032925, 60.24405375, 64.19196925, 66.828753375, 64.907128, 60.846705375, 57.302711625, 54.03383175, 51.647729, 50.53057125, 50.68824075, 52.235025125, 54.688328, 56.917161, 59.25922825, 60.422963625, 61.519754125, 62.55613475, 63.679864, 64.49602225, 65.1904875, 65.892396375, 66.178874125, 66.7686385, 66.8890965, 66.501838, 65.482992, 63.0943835, 62.273433625, 62.52411575, 63.16967975, 64.16278425, 66.353715875, 66.77197825, 66.624037, 66.22737575, 65.658523125, 65.088073125, 64.358718125, 63.26831775, 62.943067375, 61.756096375, 61.492126625, 61.495103, 61.665842375, 61.228774375, 60.767236375, 60.450989625, 60.73619525, 61.311037875, 62.020714875, 63.6211545, 66.5180255, 72.344582625, 79.713095625, 83.319822875, 84.249723375, 83.79813275, 83.4151215, 82.934852125, 81.602119375, 80.50039225, 78.4322785, 76.785259625, 74.854086, 73.114237125, 71.27836225, 69.479154625, 68.562071, 66.7251075, 65.32078275, 63.166555625, 61.284792, 59.939098125, 58.759932625);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(43.1840573, 42.5552757, 42.2283908, 41.9529476, 41.4280007, 41.3503871, 40.9371361, 40.7228748, 40.5118244, 40.2631994, 40.180215, 40.0323853, 39.5269949, 39.3476705, 39.1430781, 39.1650631, 39.2990371, 39.5076827, 39.4303991, 39.4967209, 39.2630381, 40.0811414, 40.5450519, 41.5367299, 42.3504511, 41.4039397, 39.6023138, 37.6860242, 36.0930312, 34.9767055, 34.462855, 34.5457059, 35.3387718, 36.713109, 37.9837216, 38.9642422, 40.4824171, 41.6198008, 42.1222124, 43.1785519, 43.6469922, 43.6445141, 43.9419305, 44.0740739, 44.1203515, 44.3529838, 44.4379339, 43.9619871, 42.294847, 41.5685055, 41.5066395, 41.4833848, 41.965228, 43.6186345, 44.0718149, 43.795395, 43.9377431, 44.1191913, 43.6420353, 42.7725885, 42.3050521, 41.7829863, 41.8866378, 41.3158649, 40.7390863, 40.4516792, 39.9881835, 39.0433571, 38.2009615, 38.3709958, 38.8748731, 39.7137162, 40.9178974, 43.5265798, 47.6556831, 52.1259908, 54.0325995, 54.3070783, 54.0943065, 53.6383429, 53.1782035, 52.6859108, 52.2985275, 51.2934829, 50.9872648, 50.9347616, 49.9193527, 49.2005553, 48.3251394, 48.4268128, 48.4878857, 47.8877175, 46.8884231, 45.9554372, 45.1872245, 44.7145126);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(405.9401223, 400.1763916, 396.9578094, 393.6304354, 389.3589855, 386.4583106, 383.8592285, 380.1516387, 376.5557758, 374.722314, 373.1895428, 370.9579852, 368.8246547, 368.2845489, 367.2814615, 364.0802231, 365.3684487, 364.9140069, 365.9465304, 368.0927431, 371.3209207, 379.1531257, 384.8907724, 390.5207156, 395.6156107, 391.122133, 381.5638641, 372.1802408, 364.6119872, 364.7886098, 366.0336806, 370.6184119, 380.0737922, 396.7729554, 410.4259983, 424.6857973, 433.4617031, 440.6339303, 446.6583248, 452.4065962, 458.3924459, 461.3400371, 465.9226645, 469.1960085, 471.7271594, 473.2417729, 471.7036475, 467.4538992, 455.1265111, 448.7911108, 449.1690618, 452.1156259, 457.9921035, 472.6714559, 477.0617394, 477.2930762, 476.0246146, 471.4789738, 470.0717486, 465.043641, 460.5281652, 459.008515, 456.1921264, 451.8316607, 445.2187168, 440.6407657, 435.2726005, 427.6727009, 420.7962186, 415.9086583, 414.5944292, 414.0318918, 418.0822589, 429.9907609, 453.9137201, 476.4650612, 486.4742405, 488.2220985, 487.4081748, 484.7584776, 483.2027895, 481.588827, 480.777949, 477.1818528, 472.5368438, 466.1830766, 461.7624593, 455.906502, 452.2415281, 452.2185384, 451.6127654, 445.4677607, 439.444955, 433.3444697, 428.2922968, 421.9858734);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(55.5724816666667, 54.9238464444445, 54.3574084444444, 53.8470173333333, 53.0305304444445, 52.6297336666667, 52.0251655555556, 51.6491353333333, 51.2370048888889, 50.8568333333333, 50.7278835555556, 50.2262272222222, 49.5122216666667, 49.5220491111111, 49.4337612222222, 49.4427861111111, 49.0696125555556, 49.2038248888889, 49.61809, 50.5886283333333, 51.6076244444444, 52.6110684444444, 53.4465484444445, 54.6840768888889, 54.7593564444444, 53.4499016666667, 52.1278505555556, 50.208643, 48.0414127777778, 47.4406242222222, 47.2361663333333, 46.8661451111111, 46.3168201111111, 46.6382631111111, 47.0462477777778, 47.7456802222222, 49.1189916666667, 50.0524615555556, 51.1046145555556, 52.050531, 52.7354696666667, 53.3792245555556, 53.8918311111111, 54.2964982222222, 54.6208471111111, 54.7751244444445, 54.9286757777778, 54.9281961111111, 54.3926184444444, 53.5591032222222, 53.2881356666667, 53.5340214444444, 53.9805148888889, 55.0731812222222, 55.6269191111111, 56.1670338888889, 56.1778192222222, 56.2031931111111, 54.9525135555556, 54.928279, 54.1947777777778, 53.625137, 53.0228797777778, 52.3201013333333, 51.3580392222222, 50.4829286666667, 49.391613, 48.6989557777778, 47.5549522222222, 47.2385204444444, 46.4912862222222, 47.2156864444444, 48.3537378888889, 51.3472713333333, 57.385025, 63.4025924444444, 65.8124752222222, 66.0613614444444, 65.5427227777778, 64.8549688888889, 64.0660522222222, 63.6408048888889, 63.5980373333333, 63.0407177777778, 62.7075458888889, 62.0861151111111, 61.3494082222222, 60.2616461111111, 59.8904558888889, 61.2601676666667, 62.1567148888889, 62.6734353333333, 61.1378701111111, 60.500445, 59.2883922222222, 58.4278721111111);
    array_push($baseLoad, $baseLoadTmp);

    $baseLoadTmp = array(49.6107306, 48.6687997, 48.0469525, 47.5382865, 46.8719294, 46.4266977, 45.8211409, 45.5996824, 45.2087844, 44.9157229, 44.5318092, 44.2761114, 44.1621857, 44.3658396, 43.7841621, 44.0383358, 44.1242145, 44.3849156, 44.6022766, 45.5252435, 47.4074068, 48.6579753, 49.8714834, 51.5231991, 51.5499013, 50.6029863, 49.2186277, 47.6580291, 46.0865725, 44.552641, 43.5331713, 42.6663552, 42.6353224, 43.4984125, 44.7795135, 46.4354136, 47.816831, 49.0192917, 50.1860854, 51.1537663, 51.9225965, 52.4338219, 53.0925736, 53.8518365, 54.4272075, 54.8256603, 55.0331854, 55.0159501, 54.0831098, 53.6420204, 53.1950281, 53.169501, 53.2393684, 54.3300656, 55.176137, 55.6420524, 55.6208657, 55.5434737, 55.2104635, 54.9855188, 54.3256155, 53.7512855, 52.694027, 51.8154497, 50.1998289, 48.3591964, 47.3620178, 47.1210974, 46.8189103, 47.4307731, 48.6523702, 50.4861293, 53.6186368, 58.588018, 66.6964135, 72.3960887, 73.9047654, 73.3179856, 71.2610915, 70.574181, 69.7239599, 70.1513019, 69.9319568, 68.5561007, 67.5599651, 67.023507, 66.125607, 65.2525502, 63.5921727, 62.4484864, 61.1033073, 59.7547872, 57.6009318, 55.3119096, 53.6060303, 52.1701682);
    array_push($baseLoad, $baseLoadTmp);

    $output["base"] = $baseLoad[intval($pvid) - 5];

    $targetList = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    if ($targetList[intval($pvid) - 5] == 0) {
        $output['target'] = null;
    } else {
        for ($i = 0; $i < 96; $i++) {
            $output['target'][$i] = $targetList[intval($pvid) - 5];
        }
    }

    return $output;
}

function get_load_data_1day($day, $provinceID)
{
    include "db_connection.php";

    $mySQLconn = mysql_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql) or die("Unable to connect to the database");
    mysql_select_db($DataBaseName_mysql, $mySQLconn) or die("can not select the database $DataBaseName_mysql");
    mysql_query("SET NAMES UTF8");
    $sql = "SELECT * FROM substation WHERE ProvinceID = $provinceID ORDER BY SubstationID";
    //print $sql.'<br/>';
    $res = mysql_query($sql, $mySQLconn);

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();

    $hvSub = array();
    $mvSub = array();

    while ($row = mysql_fetch_array($res)) {
        $output['SubID'][] = $row['SubstationID'];
        $output['Subname'][] = $row['SubstationName'];
        if ($row['Type'] == 1) {
            $hvSub[] = $row['SubstationID'];
        } else if ($row['Type'] == 2) {
            $mvSub[] = $row['SubstationID'];
        }
    }

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT date, time, 'total' AS Subname, 'total' AS Sub, SUM(mw) AS mw
        FROM (
        SELECT b.date, b.time, b.Subname, b.Sub, ABS(SUM(b.Load)) AS mw
                FROM Bay_Load b
                WHERE date = '$last_date' and time >= '$last_time'
                AND Sub IN ('" . implode("','", $output['SubID']) . "')
                AND SUBSTRING(bay,2,3) NOT IN ('BVB','BWB') AND SUBSTRING(bay,3,2) NOT IN ('YB')
                GROUP BY b.date, b.time, b.Sub, b.Subname
        ) AS subsum
        GROUP BY date, time

        UNION

        SELECT b.date, b.time, b.Subname, b.Sub, ABS(SUM(b.Load)) AS mw
                FROM Bay_Load b
                WHERE date = '$last_date' and time >= '$last_time'
                AND Sub IN ('" . implode("','", $mvSub) . "')
                AND SUBSTRING(bay,2,3) NOT IN ('BVB','BWB') AND SUBSTRING(bay,3,2) NOT IN ('YB')
                GROUP BY b.date, b.time, b.Sub, b.Subname";
    $query = "SELECT b.date, b.time, b.Subname, b.Sub, ABS(SUM(b.Load)) AS mw
                FROM Bay_Load b
                WHERE date = '$last_date' and time >= '$last_time'
                AND Sub IN ('" . implode("','", $mvSub) . "')
                AND SUBSTRING(bay,2,3) NOT IN ('BVB','BWB') AND SUBSTRING(bay,3,2) NOT IN ('YB')
                GROUP BY b.date, b.time, b.Sub, b.Subname";
    foreach ($hvSub as $key => $sub) {
        $hvBay = array();
        $bay = mysql_query("SELECT * FROM formula WHERE SubstationID = '$sub'", $mySQLconn);
        while ($row = mysql_fetch_array($bay)) {
            $hvBay[] = $row['Feeder'];
        }
        $query .= " UNION SELECT b.date, b.time, b.Subname, b.Sub, ABS(SUM(b.Load)) AS mw
            FROM Bay_Load b
            WHERE date = '$last_date' and time >= '$last_time'
            AND Sub = '$sub'
            AND bay IN ('" . implode("','", $hvBay) . "')
            GROUP BY b.date, b.time, b.Sub, b.Subname";
    }
    $query = "SELECT date, time, 'total' AS Subname, 'total' AS Sub, SUM(mw) AS mw
        FROM ( " . $query . " ) AS subsum
        GROUP BY date, time UNION " . $query;
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    //$data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    //$datetime = '';

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) != '5') {
            $datetime = "$row->date $row->time";
            $data[$row->Sub][$datetime] = $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }
    //$data['total'][$datetime] = $total;
    //print_r($data['total']);

    //foreach ($category as $datetime) {
        //if (date('Y-m-d') == substr($datetime, 0, 10)) {
        //$output['categories'][] = date('H:i', strtotime($datetime));
        //}
        //else {
        //    $output['categories'][] = 'เมื่อวาน ' . date('H:i', strtotime($datetime));
        //}
    //}
    $output["categories"] = array(
        "00:00", "00:30", "01:00", "01:30", "02:00", "02:30", "03:00", "03:30", "04:00", "04:30",
        "05:00", "05:30", "06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00",
        "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
        "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"
    );

    foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 48; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }

    mysql_close();
    mssql_close($conn);

    return $output;
}

function get_load_data_1day_old($day, $provinceID)
{
    include "db_connection.php";

    $conn = mysql_connect($ServerName_mysql, $UserName_mysql, $UserPassword_mysql) or die("Unable to connect to the database");
    mysql_select_db($DataBaseName_mysql, $conn) or die("can not select the database $DataBaseName_mysql");
    mysql_query("SET NAMES UTF8");
    $sql = "SELECT * FROM substation WHERE ProvinceID = $provinceID ORDER BY SubstationID";
    //print $sql.'<br/>';
    $res = mysql_query($sql, $conn);

    $data = array();
    $timestamp = array();
    $total_mw = array();
    $category = array();
    $output = array();

    while ($row = mysql_fetch_array($res)) {
        $output['SubID'][] = $row['SubstationID'];
        $output['Subname'][] = $row['SubstationName'];
    }
    mysql_close();

    $conn = mssql_connect("172.29.84.15", "smc", "1qaz@WSX");

    if ($conn === false or mssql_select_db("Load_star", $conn) === false) {
        die("Cannot connect or select SQL Server database");
    }

    //$day = strtotime($day);
    $day = date_create_from_format("d-m-Y", $day)->getTimestamp();
    //$midnight = strtotime("today midnight");
    $last_date = date("Y-m-d", $day);
    //$last_time = date("H:i", $day);
    $last_time = "00:00";

    $query = "SELECT DISTINCT b.date, b.time, b.Subname, b.Sub, ABS(SUM(b.Load)) AS mw
        FROM Bay_Load b
        WHERE date = '$last_date' and time >= '$last_time'
        AND Sub IN ('" . implode("','", $output['SubID']) . "')
        AND SUBSTRING(bay,3,2) IN ('VB','WB')
        GROUP BY b.date, b.time, b.Sub, b.Subname";
    $result = mssql_query($query);
    //print $query.'</br>';

    if ($result === false) {
        die("Error sending query to SQL Server database.");
    }

    $data['total'] = array();
    $total = 0;
    $lastDatetime = '';
    $datetime = '';

    while ($row = mssql_fetch_object($result)) {
        if (substr($row->time, -1) != '5') {
            $datetime = "$row->date $row->time";
            if ($lastDatetime != $datetime) {
                if ($lastDatetime == '') {
                    $lastDatetime = $datetime;
                } else {
                    $data['total'][$datetime] = $total;
                    $total = 0;
                    $lastDatetime = $datetime;
                }
            }
            $data[$row->Sub][$datetime] = $row->mw;
            $total += $row->mw;

            if (in_array($datetime, $category) === false) {
                $category[] = $datetime;
            }
        }
    }
    $data['total'][$datetime] = $total;
    //print_r($data['total']);

    //foreach ($category as $datetime) {
        //if (date('Y-m-d') == substr($datetime, 0, 10)) {
        //$output['categories'][] = date('H:i', strtotime($datetime));
        //}
        //else {
        //    $output['categories'][] = 'เมื่อวาน ' . date('H:i', strtotime($datetime));
        //}
    //}
    $output["categories"] = array(
        "00:00", "00:30", "01:00", "01:30", "02:00", "02:30", "03:00", "03:30", "04:00", "04:30",
        "05:00", "05:30", "06:00", "06:30", "07:00", "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00",
        "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
        "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00", "21:30", "22:00", "22:30", "23:00", "23:30"
    );

    foreach ($data as $sub => $item) {
        $count = 0;
        foreach ($item as $key => $value) {
            $output['values'][$sub][] = number_format($value, 2, ".", "");
            $count++;
        }

        for ($i = 48; $i > $count; $i--) {
            $output['values'][$sub][] = null;
        }
    }

    mssql_close($conn);

    return $output;
}

?>
