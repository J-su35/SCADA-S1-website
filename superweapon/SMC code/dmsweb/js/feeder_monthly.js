$(document).ready(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',
        maxDate: '0',
        minDate: new Date(2014, 8, 19)
    });

    $( "#datepicker2" ).datepicker({
        dateFormat: 'dd-mm-yy',
        maxDate: '0',
        minDate: $('#datepicker').val()
    });

    $('#datepicker').change(function() {
        //updateChart2();
		$("#datepicker2").datepicker('option', 'minDate', $('#datepicker').val());
        if($("#area_selector").val() == "Total" || $("#substation_selector").val() == "Total"){
            $("#load-chart").hide();
            $("#spantext").show();
            if ($("#area_selector").val() == "Total")
                $("#spantext").text("กรุณาเลือกเขตที่ต้องการ");
            else
                $("#spantext").text("กรุณาเลือกสถานีที่ต้องการ");
        }else{
            $("#spantext").text("กรุณารอสักครู่ กำลังโหลดข้อมูล...");
            showCurve();
        }
    });

    $("#area_selector").change(function(){
        //updateChart2();
        var value = $("#area_selector").val();
        if(value == "Total"){
            $("#substation_selector").hide();
            $("#spantext").text("กรุณาเลือกเขตที่ต้องการ");
        }else{
            $("#substation_selector").show();
            $("#spantext").text("กรุณาเลือกสถานีที่ต้องการ");
        }
    });

    $("#substation_selector").change(function(){
        if($("#substation_selector").val() != "Total"){
            showCurve();
        }
    });

    /*$("#area_selector").change(function(){
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        var hasData = showCurve();
        return false;
    });*/

    function updateChart2(){
        //var chart = $('#load-chart').highcharts();
        //chart.showLoading();
        showCurve();
        //chart.hideLoading();
    }


    function showCurve(){
        $("#spantext").text("กรุณารอสักครู่ กำลังโหลดข้อมูล...").fadeIn();
        //$("#load-chart").fadeOut();
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: 'feeder_monthly', datestop: $("#datepicker2").val(), area: $("#area_selector").val(), substation: $("#substation_selector").val()}, function(data) {
            //alert(data['SubID']);
            if(data['available'] == 1){
                /*var chart = $('#load-chart').highcharts();
                chart.destroy();
                chart = new Highcharts.Chart(defaultOptions);*/
                $("#spantext").text('ไม่มีข้อมูล');
                $("#load-chart").hide();
                return;
            }else{
                $("#spantext").hide();
                $("#load-chart").show();
            }
            var regions = data['name'];
            var provinceName = data['name'];
            var series = [];
            var colorSPPVSPP = ['#1b32de', '#4978e2', '#0e7b14', '#50cf77', '#BB1010'];
            var colorSPPVSPPType = ['#4A89DC','#37BC9B','#F6BB42','#DA4453','#D770AD','#3BAFDA','#8CC152','#E9573F','#967ADC','#5D9CEC','#48CFAD','#F6BB42','#ED5565','#EC87C0','#4FC1E9','#A0D468','#FC6E51','#AC92EC','#BB1010'];
            var colorBootflatSecond = ['#4A89DC','#8CC152','#F6BB42','#E9573F','#967ADC','#3BAFDA','#DA4453','#37BC9B','#D770AD'];
            var colorSet = [];
            var chartHeader = '';
            var legendSetting = {};

            /*if($("#area_selector").val() == "Total"){
                chartHeader = 'โหลดรวมของทุกจังหวัด';
            }
            else{*/
                var date = $("#datepicker").val().split("-");
                var day = date[0]+'/'+date[1]+'/'+date[2];
				var date1 = $("#datepicker2").val().split("-");
				var day1= date1[0]+'/'+date1[1]+'/'+date1[2];
                chartHeader = 'โหลดของสถานี '+$("#substation_selector").val()+' วันที่ '+ day + ' ถึง วันที่ ' + day1;
           // }

            /*series.push({
                type: 'areaspline',
                name: provinceName,
                data: data['values'][regions],
            });*/

            //alert(regions);


				legendSetting = {
                    align: 'right',
                    layout: 'vertical',
                    x: -25,
                    //width: 900,
                    //itemWidth: 100,
                    borderWidth: 1,
                    itemHiddenStyle: {
                        color: 'grey'
                    },
                    backgroundColor: '#333333',
                };
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
                        type: 'areaspline',
                        name: provinceName[i]+' [Max]',
                        data: data['values'][regions[i]],
						visible: false,
                    });
					series.push({
                        type: 'spline',
                        name: provinceName[i]+' [Min]',
						data: data['valuesMin'][regions[i]],
						visible: false,
                    });
                }
            }

            /*series.push({
                type: 'spline',
                name: 'Total',
                data: data['values']['Total'],
            });*/
            //$('#province-info').html(provinceInfo);

            /*series.push({
                type: 'spline',
                name: 'Base Load',
                data: data['base'],
                visible: true
            });*/

            $('#load-chart').highcharts({
                chart: {
                    //width: (($(window).width())*0.95),
                    renderTo: 'load-chart',
                    animation: { duration: 1000 },
                },
                colors: colorBootflatSecond,
                title: {
                    text: chartHeader,
                    //margin: 10
                },
                subtitle: {
                    //text: 'ที่มา: ระบบ SCADA/DMS'
                },
                legend: legendSetting,
                series: series,
                xAxis: {
                    categories: data['categories'],
                    tickInterval: 4,
                    tickmarkPlacement: 'on',
                },
                yAxis: { // Primary yAxis
                    labels: {
                        formatter: function() {
                            return format('#,###.', this.value);
                        },
                    },
                    title: {
                        text: 'ปริมาณกำลังผลิตรวม (MW)',
                    }
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = this.x +' น.';
                        var sum = 0;

                        $.each(this.points, function(i, point) {
                            s += '<br/><span style="color: ' + point.series.color + ';">' + point.series.name + '</span>: <strong>'+ format('#,###.##', point.y) + ' MW</strong>';
                            if (point.series.name != 'Base Load') {
                                sum += point.y;
                            }
                            else {
                                s += '<br/> ';
                            }
                        });

                        s += '<br/><br/>Feeder total: <strong>' + sum.toFixed(2) + ' MW</strong>';
                        return s;
                    }
                    //valueSuffix: ' MW',
                    /*formatter: function() {
                        return '' + this.x + ': ' + $.format.number(this.y, '#,###') + ' MW';
                    }*/
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        marker: {
                            enabled: false
                        },
                        //visible: false
                    },
                    areaspline: {
                        stacking: 'normal'
                    }
                }
            });
        });
    }
});
