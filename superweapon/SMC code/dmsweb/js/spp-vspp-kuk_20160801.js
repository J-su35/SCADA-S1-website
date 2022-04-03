$(document).ready(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',
        maxDate: '0',
        minDate: new Date(2014, 4, 24)
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
        updateChart();
    });

    $("#area_selector").change(function(){
        updateChart();
    });

    /*$("#area_selector").change(function(){
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        var hasData = showCurve(); 
        return false;
    });*/

    function updateChart(){
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: $("#mode").text(), area: $("#area_selector").val()}, function(data) {
            var regions = data['name'];            

            for (i = 0; i < regions.length; i++) {
                chart.series[i].setData(data['values'][regions[i]], false);
            }
            chart.series[regions.length].setData(data['values']['Total'], false);

            var chartHeader = '';
            if($("#mode").text() == "spp-vspp"){
                chartHeader = 'กำลังผลิตของ SPP และ VSPP ของเขต '+data['area'];
            }
            else if($("#mode").text() == "spp-vspp-type"){
                chartHeader = 'กำลังผลิตของ SPP และ VSPP แบบแยกประเภทเชื้อเพลิง ของเขต '+data['area'];
            }
            chart.setTitle({text: chartHeader});
            
            chart.redraw();
            chart.hideLoading();
        }); 
    }

    function showCurve(){    
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: $("#mode").text(), area: $("#area_selector").val()}, function(data) {
            //alert(data['SubID']);
            if(data['available'] == 1){
                /*var chart = $('#load-chart').highcharts();
                chart.destroy();
                chart = new Highcharts.Chart(defaultOptions);*/
                return;
            }
            var regions = data['name'];
            var provinceName = data['label']
            var series = [];
            var colorSPPVSPP = ['#1b32de', '#4978e2', '#0e7b14', '#50cf77', '#BB1010'];
            var colorSPPVSPP = ['#FFCE54', '#F6BB42', '#0e7b14', '#50cf77', '#BB1010'];
            var colorSPPVSPPType = ['#4A89DC','#37BC9B','#F6BB42','#DA4453','#D770AD','#3BAFDA','#8CC152','#E9573F','#967ADC','#5D9CEC','#48CFAD','#F6BB42','#ED5565','#EC87C0','#4FC1E9','#A0D468','#FC6E51','#AC92EC','#BB1010'];            
            var colorSet = [];
            var chartHeader = '';
            var legendSetting = {};            
            if($("#mode").text() == "spp-vspp"){
                colorSet = colorSPPVSPP;
                chartHeader = 'กำลังผลิตของ SPP และ VSPP ของเขต '+data['area'];
            }
            else if($("#mode").text() == "spp-vspp-type"){
                colorSet = colorSPPVSPPType;
                chartHeader = 'กำลังผลิตของ SPP และ VSPP แบบแยกประเภทเชื้อเพลิง ของเขต '+data['area'];
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
            }

            for (i = 0; i < regions.length; i++) {
                series.push({
                    type: 'areaspline',
                    name: provinceName[i],
                    data: data['values'][regions[i]],
                });
            }

            series.push({
                type: 'spline',
                name: 'Total',
                data: data['values']['Total'],
            });
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
                colors: colorSet,
                title: {
                    text: chartHeader,
                    //margin: 10
                },
                subtitle: {
                    //text: 'ที่มา: ระบบ SCADA/DMS'
                },
                events: {
                    load: function() {
                        // set up the updating of the chart each second
                        var series = this.series[0];
                        setInterval(function(){
                            alert('update');
                            var chart = new Highcharts.Chart(options);
                            $.getJSON('data.php',{date: $("#datepicker").val(), mode: $("#mode").text(), area: $("#area_selector").val()}, function(data) {
                                //options.series[0].data = JSON.parse(data.cpu);
                                var regions = data['name'];            

                                for (i = 0; i < regions.length; i++) {
                                    this.series[i].setData(data['values'][regions[i]], false);
                                }
                                this.series[regions.length].setData(data['values']['Total'], false);
                                
                                this.redraw();
                            });
                        }, 5000);
                    }     
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
        });
    }        
});
