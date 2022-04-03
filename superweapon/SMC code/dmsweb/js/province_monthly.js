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

    $( "#datepicker" ).change(function() {
        $("#datepicker2").datepicker('option', 'minDate', $('#datepicker').val());
    });

    /*$( "#datepicker2" ).datepicker({
        dateFormat: 'dd-mm-yy'
    });*/
    //showCurve();

    /*$('#datepicker').change(function() {
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        var hasData = showCurve();
        return false;
    });*/

    $('#datepicker').change(function() {
        updateChart2();
    });

    $('#datepicker2').change(function() {
        updateChart2();
    });

    /*$("#area_selector").change(function(){
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
    });*/

    $("#area_selector").change(function(){
        /*updateChart2('area','');
        var value = $("#area_selector").val();
        if (value == "Total") {
            $("#province_selector").hide();
        } else {
            $("#province_selector").show();
        }*/
        $("#province_selector").show();
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

    function updateChart2(){
        //var chart = $('#load-chart').highcharts();
        //chart.showLoading();
        showCurve();
        //chart.hideLoading();
    }

    function updateChart(){
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: 'province_monthly', area: $("#area_selector").val(), province: $("#province_selector").val()}, function(data) {
            var regions = data['name'];

            //for (i = 0; i < regions.length; i++) {
                chart.series[0].setData(data['values'][regions], false);
            //}
            //chart.series[regions.length].setData(data['values']['Total'], false);

            var chartHeader = '';
            if($("#area_selector").val() == "Total"){
                if($("#province_selector").val() == "Total"){
                    chartHeader = 'โหลดรวมของทุกจังหวัด';
                }
            }
            else{
                if($("#province_selector").val() == "Total"){
                    chartHeader = 'โหลดรวมของเขต '+$("#area_selector").val();
                }
                else{
                    chartHeader = 'โหลดของจังหวัด'+$("#province_selector option:selected").text();
                }
            }
            chart.setTitle({text: chartHeader});

            chart.redraw();
            chart.hideLoading();
        });
    }

    function showCurve(){
        $("#spantext").text("กรุณารอสักครู่ กำลังโหลดข้อมูล...").fadeIn();
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: 'province_monthly', datestop: $("#datepicker2").val(), area: $("#area_selector").val(), province: $("#province_selector").val()}, function(data) {
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
            var provinceName = data['label'];
            var series = [];
            var colorSPPVSPP = ['#1b32de', '#4978e2', '#0e7b14', '#50cf77', '#BB1010'];
            var colorSPPVSPPType = ['#4A89DC','#37BC9B','#F6BB42','#DA4453','#D770AD','#3BAFDA','#8CC152','#E9573F','#967ADC','#5D9CEC','#48CFAD','#F6BB42','#ED5565','#EC87C0','#4FC1E9','#A0D468','#FC6E51','#AC92EC','#BB1010'];
            var colorBootflatSecond = ['#4A89DC','#8CC152','#F6BB42','#E9573F','#967ADC','#3BAFDA','#DA4453','#37BC9B','#D770AD'];
            var colorSet = [];
            var chartHeader = '';
            var legendSetting = {};

            //$("#info").text('TP Rate');

            if($("#area_selector").val() == "Total"){
                chartHeader = 'โหลดรวมของทุกจังหวัด';
            }
            else{
                chartHeader = 'โหลด สูงสุด-ต่ำสุด ต่อวันของจังหวัด '+$("#province_selector").val();
            }

            /*series.push({
                type: 'areaspline',
                name: provinceName,
                data: data['values'][regions],
            });*/

            //alert(regions);

            /*for (i = 0; i < regions.length; i++) {
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
                        name: provinceName[i]+' [Max]',
                        data: data['values'][regions[i]],
                    });
                    series.push({
                        yAxis: 1,
                        type: 'area',
                        name: provinceName[i]+' % [Max]',
                        data: data['valuesPercent'][regions[i]],
                    });
					series.push({
                        type: 'spline',
                        name: provinceName[i]+' [Min]',
                        data: data['valuesmin'][regions[i]],
                    });
                    series.push({
                        yAxis: 1,
                        type: 'area',
                        name: provinceName[i]+' % [Min]',
                        data: data['valuesPercentMin'][regions[i]],
                    })
                }
                tprate += '<li >'+regions[i] +': '+ data['tprate'][regions[i]] + ' MVA</li>';
            }
            tprate += '</ul>';
            $("#tp-rate-content").html(tprate);
            $("#tp-rate").show();*/
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
                    zoomType: 'x',
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
                    name: 'Date',
                    categories: data['categories'],
                    tickInterval: 4,
                    tickmarkPlacement: 'on',
                },
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value}',
                        /*formatter: function() {
                            return format('#,###.', this.value);
                        },*/
                    },
                    title: {
                        text: 'ปริมาณกำลังผลิต (MW)',
                    }
                }],
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

                        s += '<br/><br/>Total: <strong>' + sum.toFixed(2) + ' MW</strong>';
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
                },
                exporting: {
                    csv: {
                        dateFormat: '%Y-%m-%d'
                    }
                }
            });
        });
    }
});
