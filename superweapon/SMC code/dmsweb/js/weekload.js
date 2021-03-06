$(document).ready(function() {

    function getUrlParameter(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++)
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam)
            {
                return sParameterName[1];
            }
        }
    }

    $( "#datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',
        maxDate: '0',
        minDate: new Date(2014, 8, 19)
    });

    /*$( "#datepicker2" ).datepicker({
        dateFormat: 'dd-mm-yy'
    });*/

    showCurve();

    /*$('#datepicker').change(function() {
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        var hasData = showCurve();
        return false;
    });*/

    $('#datepicker').change(function() {
        updateChart2('date','');
    });

    $("#area_selector").change(function(){
        updateChart2('area','');
        var value = $("#area_selector").val();
        if (value == "Total") {
            $("#province_selector").hide();
        } else {
            $("#province_selector").show();
        }
    });

    $("#province_selector").change(function(){
        updateChart2('province');
    });

    /*$("#area_selector").change(function(){
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        var hasData = showCurve();
        return false;
    });*/
    function updateChart2(updateFrom){
        //var chart = $('#load-chart').highcharts();
        //chart.showLoading();
        showCurve(updateFrom);
        //chart.hideLoading();
    }

    function updateChart(updateFrom){
        var province = '';
        if(updateFrom == 'area'){
            province = 'Total';
        }
        else{
            province = $("#province_selector").val();
        }
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: 'weekload'}, function(data) {
            var regions = data['name'];

            //for (i = 0; i < regions.length; i++) {
                chart.series[0].setData(data['values'][regions], false);
            //}
            //chart.series[regions.length].setData(data['values']['Total'], false);

            var chartHeader = '';
            chartHeader = '?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????';
            // if($("#area_selector").val() == "Total"){
            //     if($("#province_selector").val() == "Total"){
            //         chartHeader = '?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????';
            //     }
            // }
            // else{
            //     if($("#province_selector").val() == "Total"){
            //         chartHeader = '??????????????????????????????????????? '+$("#area_selector option:selected").text();
            //     }
            //     else{
            //         chartHeader = '??????????????????????????????????????????'+$("#province_selector option:selected").text();
            //     }
            // }
            chart.setTitle({text: chartHeader});

            chart.redraw();
            chart.hideLoading();
        });
    }

    function showCurve(updateFrom){
        // var now = new Date();
        // $("#datepicker").val(now.getDate()+'-'+(now.getMonth()<10? '0'+now.getMonth():now.getMonth())+'-'+now.getFullYear());
        $("#spantext").text("?????????????????????????????????????????? ?????????????????????????????????????????????...").fadeIn();
        var province = '';
        if(updateFrom == 'area'){
            province = 'Total';
            //$("#province_selector").hide();
        }
        else{
            province = $("#province_selector").val();
        }
        /*var startArea = getUrlParameter('area');
        if(startArea != null){
            $("#area_selector").val(startArea).change();
        }*/
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: 'weekload'}, function(data) {
            //alert(data['SubID']);
            if(data['available'] == 1){
                /*var chart = $('#load-chart').highcharts();
                chart.destroy();
                chart = new Highcharts.Chart(defaultOptions);*/
                $("#spantext").text('?????????????????????????????????');
                $("#load-chart").hide();
                return;
            }else{
                $("#spantext").hide();
                $("#load-chart").show();
            }
            var regions = data['name'];
            // if(data['12Area'] == 1){
            //     regions = ['N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3','Total','Peak','Yesterday'];
            // }
            var provinceName = data['label'];
            var series = [];
            var colorSPPVSPP = ['#1b32de', '#4978e2', '#0e7b14', '#50cf77', '#BB1010'];
            var colorSPPVSPPType = ['#4A89DC','#37BC9B','#F6BB42','#DA4453','#D770AD','#3BAFDA','#8CC152','#E9573F','#967ADC','#5D9CEC','#48CFAD','#F6BB42','#ED5565','#EC87C0','#4FC1E9','#A0D468','#FC6E51','#AC92EC','#BB1010'];
            var colorBootflatSecond = ['#4A89DC','#8CC152','#F6BB42','#E9573F','#967ADC','#3BAFDA','#DA4453','#37BC9B','#D770AD'];
            var colorSundayStart = ['#C31010','#FFEE00','#FF69B4','#228B22','#FFA500','#1E90FF','#8B2C8B'];
            var colorByDayOfWeek = [];
            var colorSet = [];
            var chartHeader = '';
            var legendSetting = {};
            var date = $("#datepicker").val().split("-");
            var day = date[0]+'/'+date[1]+'/'+date[2];

            chartHeader = '?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????';

            var indexDay = data['startday'];
            var counter = 0;
            while(counter <= 6){
              colorByDayOfWeek.push(colorSundayStart[indexDay]);
              if(indexDay == 6){
                indexDay = 0;
              }
              else{
                indexDay++;
              }
              counter++;
            }

            for (i = 0; i < regions.length; i++) {
              if(i == regions.length-1){
                series.push({
                    type: 'spline',
                    name: provinceName[i],
                    data: data['values'][regions[i]],
                    lineWidth: 4
                });

              }
              else{
                series.push({
                    type: 'spline',
                    name: provinceName[i],
                    data: data['values'][regions[i]],
                });
              }
            }

            $('#load-chart').highcharts({
                chart: {
                    renderTo: 'load-chart',
                    animation: { duration: 1000 },
                },
                colors: colorByDayOfWeek,
                title: {
                    text: chartHeader,
                    //margin: 10
                },
                subtitle: {
                    //text: '???????????????: ???????????? SCADA/DMS'
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
                        text: '?????????????????????????????????????????????????????? (MW)',
                    }
                },
                tooltip: {
                    shared: true,
                    /*formatter: function() {
                        var s = this.x +' ???.';
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

                        //s += '<br/><br/>Area total: <strong>' + sum.toFixed(2) + ' MW</strong>';
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
