<?php
include("db_connection.php");
ini_set('mssql.charset', 'UTF-8');
$conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
    die("Cannot connect or select SQL Server database");
}
//$query = "SELECT DISTINCT Sub, Sub AS Subname, Area FROM substation_tp WHERE tp IS NOT NULL ORDER BY Area, Sub";
$query = "SELECT DISTINCT st.SubstationCode Sub, s.SubstationCode Subname, st.DistrictCode Area
FROM Substation.dbo.Feeder st left join Substation.dbo.Substation s on st.SubstationCode = s.SubstationCode and st.DistrictCode COLLATE Thai_CI_AS = s.RegionCode COLLATE Thai_CI_AS
WHERE st.TransformerCode IN ('TP1','TP2','TP3','TP4','TP5') ORDER BY st.DistrictCode, st.SubstationCode";
$result = mssql_query($query);
if ($result === false) {
    die("Error sending query to SQL Server database.");
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
		array_push($provinceKeyList[trim($row->Area)], 'Total');
		array_push($provinceNameList[trim($row->Area)], 'Total');
	}
	array_push($provinceKeyList[trim($row->Area)], trim($row->Sub));
	array_push($provinceNameList[trim($row->Area)], trim($row->Subname));
	$provinceKeyNameList[trim($row->Sub)] = trim($row->Sub);
	$provinceNameList2[trim($row->Sub)] = trim($row->Subname);
	//array_push($provinceNameList[trim($row->Area)],  mb_detect_encoding(trim($row->ProvinceName), mb_detect_order(), true) === 'UTF-8' ? trim($row->ProvinceName) : mb_convert_encoding(trim($row->ProvinceName), 'UTF-8'));
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Daily Peak Load</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="css/site.min.css">
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.4.min.css">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

		<script type="text/javascript" src="js/site.min.js"></script>
		<script type="text/javascript" src="js/highcharts.js"></script>
		<script type="text/javascript" src="js/exporting.js"></script>
		<script type="text/javascript" src="js/export-csv.js"></script>
		<script type="text/javascript" src="js/themes/gray.js"></script>
		<script type="text/javascript" src="js/format.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10.4.min.js"></script>
		<script type="text/javascript" src="js/daily_peak_load.js"></script>

		<script type="text/javascript">
			/*
			Triple Combo Script Credit
			By Philip M: http://www.codingforums.com/member.php?u=186
			Visit http://javascriptkit.com for this and over 400+ other scripts
			*/

			var categories = [];
			var areaList = <?php echo json_encode($areaList); ?>;
			var provinceKey = <?php echo json_encode($provinceKeyList); ?>;
			var provinceName = <?php echo json_encode($provinceNameList); ?>;
			var provinceKeyName = <?php echo json_encode($provinceKeyNameList); ?>;
			var provinceName2 = <?php echo json_encode($provinceNameList2); ?>;
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
			            if(lcn == 'Total'){
			        		return '<option value="' + lcn + '">' + provinceKeyName[lcn] + '</option>';
			        	}
			        	else{
			        		return '<option value="' + lcn + '">' + provinceKeyName[lcn] + ' - ' + provinceName2[lcn] + '</option>';
			        	}
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
                <!-- <li><a href="index.php">Province Load</a></li> -->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Load Profile <b class="caret"></b></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">Load Profile</li>
                    <li><a href="index.php">Province Load</a></li>
                    <li><a href="weekload.php">7-Days Load</a></li>
                    <li><a href="#">Daily Peak Load</a></li>
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
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Feeder Load<b class="caret"></b></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">โหลดรายฟีดเดอร์</li>
                    <li><a href="feeder.php">Daily</a></li>
                    <li><a href="feeder_monthly.php">Monthly</a></li>
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
				<div class="col-lg-7" >
					<form class="form-inline" role="form" id="select_form">
            <div class="form-group">
                <label class="sr-only" for="datepicker">Date</label>
                <!--<input type="text" class="form-control text-center" id="datepicker" readonly value="<?//php echo date("d-m-Y", strtotime("-1 month")); ?>" style="padding-top: 10px; font-weight: bold; font-size: 16px; width: 120px; height: 34px; cursor: pointer; color: #2f7ed8; background-color: #ffffff;">-->
                <input type="text" class="form-control text-center" id="datepicker" readonly value="<?php echo date("01-m-Y", strtotime("-1 month")); ?>" style="font-weight: bold; font-size: 16px; text-align: center; width: 120px; height: 34px; cursor: pointer; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px;">
                <font color="white"> to </font>
                <input type="text" class="form-control text-center" id="datepicker2" readonly value="<?php echo date("t-m-Y", strtotime("-1 month")); ?>" style="font-weight: bold; font-size: 16px; text-align: center; width: 120px; height: 34px; cursor: pointer; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px;">

                <fieldset id="match_radio">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="match_option" id="inlineRadio1" value="match_dow" checked>
                    <label class="form-check-label" for="inlineRadio1"><font color="white">Match Day of Week</font></label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="match_option" id="inlineRadio2" value="match_date">
                    <label class="form-check-label" for="inlineRadio2"><font color="white">Match Date</font></label>
                  </div>
                </fieldset>
            </div>
					</form>
				</div>
			</div>

			<div class="row chart">
				<div class="col-lg-12">
					<div class="text-center well" id="spantext" style="font-weight: bold; padding: 10px; margin-bottom: 5px">กรุณาเลือกเขตที่ต้องการ</div>
					<div id="load-chart"></div>
				</div>
			</div>

      <div class="row">
				<div class="col-lg-12">
					<div class="panel panel-info" id="info">
						<div class="panel-heading"><h3 class="panel-title">ช่วงวันที่ของปีก่อนหน้า</h3></div>
						<div class="panel-body" id="info-content"></div>
  				</div>
  			</div>
  		</div>

      <div class="row control" style="display:none">
        <div class="col-lg-12">
					<p style="color:white;">Last Year Curve Control</p>
          <button class="btn-move-left">
            move left
          </button>
          <button class="btn-move-right">
            move right
          </button>
        </div>
      </div>
	</body>
</html>
