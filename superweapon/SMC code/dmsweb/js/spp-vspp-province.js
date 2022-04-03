$(document).ready(function() {

    //$("#no-data").hide();

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
    });

    $("#spp_vspp_selector").change(function(){
        updateChart2('sppvspp');
    });

    $("#province_selector").change(function(){
        updateChart2('province');
    });

    $("#hvmv_selector").change(function(){
        updateChart2('hvmv');
    });

    $("#type_selector").change(function(){
        updateChart2('type');
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

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    function showCurve(updateFrom){
        $("#spantext").text("กรุณารอสักครู่ กำลังโหลดข้อมูล...").fadeIn();
        var province = '';
        if(updateFrom == 'area'){
            province = 'Total';
        }
        else{
            province = $("#province_selector").val();
        }
        /*var startArea = getUrlParameter('area');
        if(startArea != null){
            $("#area_selector").val(startArea).change();
        }*/
        var serverIP = getUrlParameter('server');
        $.getJSON('data.php',{server: serverIP,date: $("#datepicker").val(), mode: 'spp-vspp-province', area: $("#area_selector").val(), sppvspp: $("#spp_vspp_selector").val(), province: province, hvmv: $("#hvmv_selector").val(), type: $("#type_selector").val()}, function(data) {
            //alert(data['SubID']);
            if(data['available'] == 1){
                /*var chart = $('#load-chart').highcharts();
                chart.destroy();*/
                //document.getElementById('load-chart').style.visibility ='hidden';
                //$('#load-chart').find('.highcharts-container').hide();
                $("#spantext").text('ไม่มีข้อมูล');
                $("#load-chart").hide();
                return;
            }
            else{
                $("#spantext").hide();
                $("#load-chart").show();

                var regions = data['name'];
                if(data['12Area'] == 1){
                    regions = ['N1','N2','N3','NE1','NE2','NE3','C1','C2','C3','S1','S2','S3'];
                }
                var provinceName = data['label'];
                var series = [];
                var colorSPPVSPP = ['#1b32de', '#4978e2', '#0e7b14', '#50cf77', '#BB1010'];
                var colorSPPVSPPType = ['#4A89DC','#37BC9B','#F6BB42','#DA4453','#D770AD','#3BAFDA','#8CC152','#E9573F','#967ADC','#5D9CEC','#48CFAD','#F6BB42','#ED5565','#EC87C0','#4FC1E9','#A0D468','#FC6E51','#AC92EC','#BB1010']; 
                var colorBootflatSecond = ['#4A89DC','#8CC152','#F6BB42','#E9573F','#967ADC','#3BAFDA','#DA4453','#37BC9B','#D770AD'];           
                var colorSet = [];
                var chartHeader = '';
                var legendSetting = {};
                var date = $("#datepicker").val().split("-");
                var day = date[0]+'/'+date[1]+'/'+date[2];

                if ($("#area_selector").val() == "Total"){
                    chartHeader = 'โหลดรวมของ'+$("#area_selector option:selected").text()+' วันที่ '+ day;
                }else{
                    chartHeader = 'โหลดรวมของเขต '+$("#area_selector option:selected").text()+' วันที่ '+ day;
                }
				/*series.push({
                    type: 'areaspline',
                    name: provinceName,
                    data: data['values'][regions],
                });*/

                //alert(regions);

                for (i = 0; i < regions.length; i++) {
                    //alert(i);
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
                            name: provinceName[i],
                            data: data['values'][regions[i]],
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
                        /*formatter: function() {
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
            }          
        });
    }        
});
