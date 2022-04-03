<?php
include("db_connection.php");
ini_set('mssql.charset', 'UTF-8');
$conn = mssql_connect("172.30.203.154", "smc", "1qaz@WSX");

if ($conn === false or mssql_select_db("SCADA", $conn) === false) {
    die("Cannot connect or select SQL Server database");
}

//$query = "SELECT DISTINCT st.Sub, s.Subname, st.Area
//FROM substation_tp st left join Sub_Dim s on st.Sub = s.Sub and st.Area COLLATE Thai_CI_AS = s.Area COLLATE Thai_CI_AS
//WHERE tp IS NOT NULL ORDER BY st.Area, st.Sub";

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
	//echo trim($row->Sub); echo " : "; echo trim($row->Subname);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Daily Transformer Load</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="css/site.min.css">
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.4.min.css">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>

		<script type="text/javascript" src="js/site.min.js"></script>
		<script type="text/javascript" src="js/highcharts.js"></script>
		<script type="text/javascript" src="js/exporting.js"></script>
		<script type="text/javascript" src="js/export-csv.js"></script>
		<!-- <script type="text/javascript" src="js/themes/gray.js"></script> -->
		<script type="text/javascript" src="js/format.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.10.4.min.js"></script>
		<script type="text/javascript" src="js/tp_daily.js"></script>

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
                    <li><a href="#">Daily</a></li>
                    <li><a href="tp_monthly.php">Monthly</a></li>
                  </ul>
                </li>
				<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Feeder Load <b class="caret"></b></a>
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
				<div class="col-lg-7">
					<form class="form-inline" role="form"  id="select_form">
			            <div class="form-group">


			                <label class="sr-only" for="datepicker">Date</label>
			                <!--<input type="text" class="form-control text-center" id="datepicker" readonly value="<?//php echo date("d-m-Y"); ?>" style="padding-top: 10px; font-weight: bold; font-size: 16px; width: 120px; height: 34px; cursor: pointer; color: #2f7ed8; background-color: #ffffff;/*color: #ffffff; background-color: rgba(47,126,217,.5);*/"-->
                      <input type="text" class="form-control text-center" id="datepicker" readonly value="<?php echo isset($_GET['date'])? date("d-m-Y", strtotime($_GET['date'])) : date("d-m-Y", strtotime("-1 month")); ?>" style="font-weight: bold; font-size: 16px; text-align: center; width: 120px; height: 34px; cursor: pointer; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px;">

                      <label class="sr-only" for="area_selector">เลือกเขต</label>
			               <!-- <select id="area_selector" name="List1">-->
                     <select id="area_selector" name="List1" class="form-control" style="width:100px; color: #000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px 2px">

			                	<?php
			                	$area = array('Total','N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3');
			                	foreach($area as $v){
			                		if($v == 'Total')
			                		{
			                			echo "<option value=\"$v\">เลือกเขต</option>";
			                		}
			                		else
			                		{
			                			if (isset($_GET['area'])) {
			                				if ($_GET['area'] == $v) {
			                					echo "<option value=\"$v\" selected>$v</option>";
			                				} else {
			                					echo "<option value=\"$v\">$v</option>";
			                				}

			                			} else {
			                				echo "<option value=\"$v\">$v</option>";
			                			}
			                		}
			                	}
			                	?>
			                </select>
			                <!--<select name='List2' id="substation_selector">-->


                      <?php if(isset($_GET['sub'])) { ?>
                       	<select name='List2' id="substation_selector" class="form-control " style="width:110px; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px;">
                       		<option value="<?=$_GET['sub']?>" selected><?=$_GET['sub']?></option>
						</select>
                       <?php } else { ?>
                       	<select name='List2' id="substation_selector" class="form-control " style="width:110px; color:#000000; background: #ffffff; box-shadow: 0px 0px 8px #000000; margin: 3px; display: none;" hidden>
                       		<option value="Total" selected></option>
						</select>
                       <?php } ?>

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
			<div class="row" id="load-chart2">
				<div class="col-lg-12">
					<div class="panel panel-default" id="tp-rate">
						<div class="panel-heading"><h3 class="panel-title">TP Rate</h3></div>
						<div class="panel-body" id="tp-rate-content"></div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		function showCurveFromWS(){
		    $("#spantext").text("กรุณารอสักครู่ กำลังโหลดข้อมูล...").fadeIn();
		    $.getJSON('data.php',{date: $("#datepicker").val(), mode: 'tp_daily', area: $("#area_selector").val(), substation: $("#substation_selector").val()}, function(data) {
		            if(data['available'] == 1){
		                $("#spantext").text('ไม่มีข้อมูล');
		                $("#load-chart").hide();
		                $("#tp-rate").hide();
		                return;
		            }else{
		                $("#spantext").hide();
		                $("#load-chart").show();
		                $("#tp-rate").show();
		            }
		            var regions = data['name'];
		            var provinceName = data['name'];
		            var series = [];
		            var colorSPPVSPP = ['#1b32de', '#4978e2', '#0e7b14', '#50cf77', '#BB1010'];
		            var colorSPPVSPPType = ['#4A89DC','#37BC9B','#F6BB42','#DA4453','#D770AD','#3BAFDA','#8CC152','#E9573F','#967ADC','#5D9CEC','#48CFAD','#F6BB42','#ED5565','#EC87C0','#4FC1E9','#A0D468','#FC6E51','#AC92EC','#BB1010'];
		            var colorBootflatSecond = ['#4A89DC','#8CC152','#F6BB42','#E9573F','#967ADC','#3BAFDA','#DA4453','#37BC9B','#D770AD'];
		            var colorMW = ['#5D9CEC','#48CFAD','#FFCE54','#FC6E51'];
		            var colorPercent = ['#4A89DC','#37BC9B','#FFCE54','#E9573F'];
					var colorLimit = ['#FFFFFF','#000000','#000000','#000000'];
		            var colorSet = [];
		            var chartHeader = '';
		            var legendSetting = {};

		            if($("#area_selector").val() == "Total"){
		                chartHeader = 'โหลดรวมของทุกจังหวัด';
		            }
		            else{
		                chartHeader = 'โหลดหม้อแปลงของสถานี '+$("#substation_selector").val();
		            }

		            var tprate = '<ul >';

		            for (i = 0; i < regions.length; i++) {
		                if(regions[i] == 'Total'){
		                    series.push({
		                        type: 'spline',
		                        name: 'Total',
		                        data: data['values']['Total'],
		                    });
		                }
		                else{
		                    series.push({
		                        type: 'spline',
		                        name: provinceName[i],
		                        data: data['values'][regions[i]],
		                        marker: {
		                        symbol: 'diamond'
		                        },
		                    });
		                    series.push({
		                        yAxis: 1,
		                        type: 'spline',
		                        name: provinceName[i]+' %',
		                        data: data['valuesPercent'][regions[i]],
		                        marker: {
		                        enabled: false
		                        },
		                    })
		                }
		                tprate += '<li >'+regions[i] +': '+ data['tprate'][regions[i]] + ' MVA</li>';
		            }

		            tprate += '</ul>';
		            $("#tp-rate-content").html(tprate);
		            $("#tp-rate").show();

		            $('#load-chart').highcharts({
		                chart: {
		                    zoomType: 'x',
		                    renderTo: 'load-chart',
		                    animation: { duration: 1000 },
		                },
		                colors: colorSPPVSPPType,
		                title: {
		                    text: chartHeader,
		                },
		                subtitle: {
		                },
		                legend: legendSetting,
		                series: series,
		                xAxis: {
		                    categories: data['categories'],
		                    tickInterval: 4,
		                    tickmarkPlacement: 'on',
		                },
		                yAxis: [{ // Primary yAxis
		                    labels: {
		                        format: '{value}',
		                    },
		                    title: {
		                        text: 'ปริมาณกำลังผลิตรวม (MW)',
		                    },
		                    min: 0,
		                    //max: 60,
		                    colors: colorMW,
		                }, { // Secondary yAxis
		                    title: {
		                        text: 'TP Utilization (%)',
		                        style: {
		                            color: Highcharts.getOptions().colors[0]
		                        }
		                    },
		                    labels: {
		                        format: '{value}',
		                        style: {
		                            color: Highcharts.getOptions().colors[0]
		                        }
		                    },
		                    min: 0,
		                    max: 100,
		                    opposite: true,
		                    colors: colorPercent,
							plotBands: [{ // Above Limit
								from: 80,
								to:	150,
								color: 'rgba(100,0,0,0.2)',
								label: {
									text: 'Dangerous Zone',
									style: {
										color: '#606060'
									}
								}
							},{ // Below Limit
								from: 0,
								to:	80,
								color: 'rgba(0,100,0,0.2)',
								label: {
									text: 'Safe Zone',
									style: {
										color: '#606060'
									}
								}
							}
							],
		                }],

		                tooltip: {
		                    shared: true,
		                },
		                credits: {
		                    enabled: false
		                },
		                plotOptions: {
		                    series: {
		                    },
		                    areaspline: {
		                        stacking: 'normal'
		                    }
		                }
		            });
		        });
		    }
		<?php if (isset($_GET['date']) && isset($_GET['area']) && isset($_GET['sub'])) {
			echo 'showCurveFromWS();';
		} ?>
		</script>
	</body>
</html>
