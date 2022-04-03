<?php
include 'includes/dbh.inc.php';
// ini_set('mssql.charset', 'UTF-8'); //origin code
// $conn = mssql_connect("scadaloaddb", "smc", "1qaz@WSX"); //origin code
$conn = mssql_connect("172.29.84.96", "smc", "1qaz@WSX");

// if ($conn === false or mssql_select_db("SCADA", $conn) === false) {  //origin code
//     die("Cannot connect or select SQL Server database feeder_monthly.php");
// }
//$query = "SELECT cast(Sub as text) as Sub, cast(Subname as text) as Subname, cast(Area as text) as Area FROM SCADA.dbo.SUBSTATION_FULLNAME";

#$query = "SELECT SUB.substation AS Sub, NAME.ThName AS Subname, SUB.substation_regionCode AS Area
#		  FROM dbo.SUBSTATION AS SUB LEFT OUTER JOIN Substation.dbo.Substation AS NAME
#		  ON SUB.substation  COLLATE DATABASE_DEFAULT = NAME.SubstationCode COLLATE DATABASE_DEFAULT
#		  WHERE (LEN(RTRIM(SUB.substation)) = 3 OR LEN(RTRIM(SUB.substation)) = 6)
#		  AND (SUB.substation <> 'AMR') AND (SUB.substation <> 'ADS') AND (SUB.substation <> 'L01')
#		  ORDER BY Area, Sub ASC";

$query = "SELECT SUB.substation AS Sub, NAME.ThName AS Subname, SUB.substation_regionCode AS Area
		  FROM dbo.SUBSTATION AS SUB LEFT OUTER JOIN Substation.dbo.Substation AS NAME
		  ON SUB.substation = NAME.SubstationCode
		  WHERE (LEN(RTRIM(SUB.substation)) = 3 OR LEN(RTRIM(SUB.substation)) = 6)
		  AND (SUB.substation <> 'AMR') AND (SUB.substation <> 'ADS') AND (SUB.substation <> 'L01')
		  ORDER BY Area, Sub ASC";

$result = mssql_query($query);
if (!$result) {
	die("(feeder.php) Error : ". mssql_get_last_message());
}
$areaList = array();
$substationKeyList = array();
$provinceNameList = array();
$provinceKeyNameList = array();
$provinceKeyNameList['Total'] = 'เลือกสถานี';
while ($row = mssql_fetch_object($result)) {
	if(!in_array($row->Area, $areaList)){
		array_push($areaList, trim($row->Area));
		$provinceKeyList[trim($row->Area)] = array();
		$provinceNameList[trim($row->Area)] = array();
		//array_push($provinceKeyList[trim($row->Area)], 'NULL');
		//array_push($provinceNameList[trim($row->Area)], 'SPP');
		array_push($provinceKeyList[trim($row->Area)], 'Total');
		array_push($provinceNameList[trim($row->Area)], 'Total');
	}
	array_push($provinceKeyList[trim($row->Area)], trim($row->Sub));
	array_push($provinceNameList[trim($row->Area)], trim($row->Subname));
	$provinceKeyNameList[trim($row->Sub)] = trim($row->Sub);
	//array_push($provinceNameList[trim($row->Area)],  mb_detect_encoding(trim($row->ProvinceName), mb_detect_order(), true) === 'UTF-8' ? trim($row->ProvinceName) : mb_convert_encoding(trim($row->ProvinceName), 'UTF-8'));
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Feeder Load</title>
		<!-- <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"> -->
		<link rel="stylesheet" href="css/site.min.css">
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.4.min.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

		<script type="text/javascript" src="js/site.min.js"></script>
		<script type="text/javascript" src="js/highcharts.js"></script>
		<script type="text/javascript" src="js/exporting.js"></script>
		<script type="text/javascript" src="js/export-csv.js"></script>
		<script type="text/javascript" src="js/themes/gray.js"></script>
		<script type="text/javascript" src="js/format.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10.4.min.js"></script>
		<script type="text/javascript" src="js/feeder_monthly.js"></script>

		<script type="text/javascript">
		/*
		Triple Combo Script Credit
		By Philip M: http://www.codingforums.com/member.php?u=186
		Visit http://javascriptkit.com for this and over 400+ other scripts
		*/

		var categories = [];
		var areaList = <?php echo json_encode($areaList); ?>;
		var provinceKey = <?php echo json_encode($provinceKeyList); ?>;
//		var provinceName = <?php echo json_encode($provinceNameList); ?>;
		var provinceKeyName = <?php echo json_encode($provinceKeyNameList); ?>;
		/*var areaList = [];
		var provinceKey = [];
		var provinceName = [];
		$.getJSON( "provinceChoice.php", function( json ) {
			areaList = json['area'];
			provinceKey = json['key'];
			provinceName = json['name'];
			alert(provinceKey[0].length);
		});*/
		categories["startList"] = [];

		for (i = 0; i < areaList.length; i++) {
			categories[areaList[i]] = provinceKey[areaList[i]];
			categories["startList"].push(areaList[i]);
		}

		var nLists = 1; // number of select lists in the set

		function fillSelect(currCat,currList){
			var step = Number(currList.name.replace(/\D/g,""));
			for (i=step; i<nLists+1; i++) {
				document.forms['select_form']['List'+i].length = 1;
				document.forms['select_form']['List'+i].selectedIndex = 0;
			}

			var nCat = categories[currCat];
			if(currCat == "startList" || currCat == "Total"){
				for (each in nCat) {
					var nOption = document.createElement('option');
					var nData = document.createTextNode(nCat[each]);
					nOption.setAttribute('value',nCat[each]);
					nOption.appendChild(nData);
					currList.appendChild(nOption);
				}
			}
			else{
				var nCatName = provinceName[currCat];
				for (i=0; i<nCat.length; i++) {
					var nOption = document.createElement('option');
					var nData = document.createTextNode(nCatName[i]);
					nOption.setAttribute('value',nCat[i]);
					nOption.appendChild(nData);
					currList.appendChild(nOption);
				}
			}
		}

		function init() {
			//fillSelect('startList',document.forms['select_form']['List1']);
		}

		function fillProvince(currCat,currList){
			$('#substation_selector').empty();
			$('#substation_selector').append('ทุกจังหวัด');
			fillSelect(currCat,currList);
		}

		jQuery(function($) {
		    /*var locations = {
		        'Germany': ['Duesseldorf', 'Leinfelden-Echterdingen', 'Eschborn'],
		        'Spain': ['Barcelona'],
		        'Hungary': ['Pecs'],
		        'USA': ['Downers Grove'],
		        'Mexico': ['Puebla'],
		        'South Africa': ['Midrand'],
		        'China': ['Beijing'],
		        'Russia': ['St. Petersburg'],
		    }*/
		    var locations = provinceKey;

		    var $locations = $('#substation_selector');
		    $('#area_selector').change(function () {
		        var country = $(this).val(), lcns = locations[country] || [];

		        var html = $.map(lcns, function(lcn){
		            return '<option value="' + lcn + '">' + provinceKeyName[lcn] + '</option>'
		        }).join('');
		        $locations.html(html)
		    });
		});

		navigator.appName == "Microsoft Internet Explorer" ? attachEvent('onload', init, false) : addEventListener('load', init, false);

		</script>
	</head>
	<body style="background-color: #777777;">
		<div id="mode" style="display: none;">spp-vspp</div>
		<nav class="navbar navbar-inverse" role="navigation" style="margin-bottom: 5px">
		<div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-5">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">SMC</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-5">
              <ul class="nav navbar-nav">
                <!-- <li class="disabled"><a href="#">Link</a></li> -->
                <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Load Profile <b class="caret"></b></a>
		              <ul class="dropdown-menu" role="menu">
		                <li class="dropdown-header">Load Profile</li>
		                <li><a href="index.php">Province Load</a></li>
		                <li><a href="weekload.php">7-Days Load</a></li>
                    <li><a href="daily_peak_load.php">Daily Peak Load</a></li>
		              </ul>
		            </li>
				<li><a href="spp-vspp-province.php">SPP-VSPP</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transformer <b class="caret"></b></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">โหลดหม้อแปลง</li>
                    <li><a href="tp_daily.php">Daily</a></li>
                    <li><a href="tp_monthly.php">Monthly</a></li>
                  </ul>
                </li>
				<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Feeder Load <b class="caret"></b></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">โหลดรายฟีดเดอร์</li>
                    <li><a href="feeder.php">Daily</a></li>
					<li><a href="#">Monthly</a></li>
				  </ul>
				</li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
			  	<li><a href="http://172.29.84.103/Line/dashboard.php" target="_blank">ICCP Link Status</a></li>
			  </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
		<div class="container documents" style="margin-top: 0px">
			<div class="row">
				<div class="col-lg-7" style="padding-left: 5px">
					<form class="form-inline" role="form" id="select_form" name="select_form">
			            <div class="form-group">
			                <!-- <label class="sr-only" for="datepicker">Date</label> -->


                      <input type="text" class="form-control text-center" id="datepicker" readonly value="<?php echo date("d-m-Y", strtotime("-1 month")); ?>" style="font-weight: bold; font-size: 16px; text-align: center; width: 120px; height: 34px; cursor: pointer; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px;">
			                <font color="white"> to </font>

                      <input type="text" class="form-control text-center" id="datepicker2" readonly value="<?php echo date("d-m-Y"); ?>" style="font-weight: bold; font-size: 16px; text-align: center; width: 120px; height: 34px; cursor: pointer; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px;">
							        <select id="area_selector" name="List1" class="form-control" style="width:100px; color: #000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px 2px">


                        <?php
			                	$area = array('Total','N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3');
			                	$text = array('เลือกเขต','กฟน.1','กฟน.2','กฟน.3','กฟฉ.1','กฟฉ.2','กฟฉ.3','กฟก.1','กฟก.2','กฟก.3','กฟต.1','กฟต.2','กฟต.3');
			                	for($i=0;$i<count($area);$i++){
			                		if($area[$i] == "Total")
			                		{
			                			echo "<option value=\"$area[$i]\" selected>$text[$i]</option>";
			                		}
			                		else
			                		{
			                			echo "<option value=\"$area[$i]\">$text[$i]</option>";
			                		}
			                	}
			                	?>
			                </select>
			                <select name='List2' id="substation_selector" class="form-control " style="width:110px; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px; display: none;" hidden>
								<option value="Total" selected> </option>
							</select>
			            </div>
					</form>
				</div>
			</div>
			<div class="row chart">
				<div class="col-xs-12" style="padding:5px 5px 0 5px">
					<div class="text-center well" id="spantext" style="font-weight: bold; padding: 10px; margin-bottom: 5px">กรุณาเลือกเขตที่ต้องการ</div>
					<div id="load-chart"></div>
				</div>
			</div>
		</div>
	</body>
</html>
