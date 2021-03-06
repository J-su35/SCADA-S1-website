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

    $('#datepicker').change(function() {
        updateChart2();
    });

    $('#datepicker2').change(function() {
        updateChart2();
    });

    $('#match_radio input[type=radio]').change(function(){
      updateChart2();
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

    $("#info").hide();

    showCurve();

    Highcharts.Series.prototype.moveSeries = function(xShift, yShift) {
      var x, y;
      xShift = xShift || 0,
        yShift = yShift || 0;
      Highcharts.each(this.data, function(p, i) {
        x = p.x;
        y = p.y;
        p.update({
          x: x + xShift,
          y: y + yShift
        }, false);
      });
      this.chart.redraw();
    };

    $('.btn-move-right').click(function() {
      var chart = $('#load-chart').highcharts();
      chart.series[1].moveSeries(1);
    });
    $('.btn-move-left').click(function() {
      var chart = $('#load-chart').highcharts();
      chart.series[1].moveSeries(-1);
    });

    function updateChart(){
        var chart = $('#load-chart').highcharts();
        chart.showLoading();
        $.getJSON('data.php',{mode: 'daily_peak_load', date1: $("#datepicker").val(), date2: $("#datepicker2").val(), match_option: $("input[name='match_option']:checked").val()}, function(data) {
            var regions = data['name'];

            //for (i = 0; i < regions.length; i++) {
                chart.series[0].setData(data['values'][regions], false);
            //}
            //chart.series[regions.length].setData(data['values']['Total'], false);

            chart.redraw();
            chart.hideLoading();
        });
    }

    function showCurve(){
        $("#spantext").text("?????????????????????????????????????????? ?????????????????????????????????????????????...").fadeIn();
        $.getJSON('data.php',{mode: 'daily_peak_load', date1: $("#datepicker").val(), date2: $("#datepicker2").val(), match_option: $("input[name='match_option']:checked").val()}, function(data) {
            //alert(data['SubID']);
            if(data['available'] == 1){
                /*var chart = $('#load-chart').highcharts();
                chart.destroy();
                chart = new Highcharts.Chart(defaultOptions);*/
                $("#spantext").text('?????????????????????????????????');
                $("#load-chart").hide();
                $("#info").hide();
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

            chartHeader = 'Daily Peak Load';

            for (i = 0; i < regions.length; i++) {
                series.push({
                    type: 'spline',
                    name: provinceName[i],
                    data: data['values'][regions[i]],
                });
            }
            if(data['startDateAgo'] != null){
              $("#info-content").html(data['startDateAgo']+'  -  '+data['lastDateAgo']);
              $("#info").show();
            }

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
                    //text: '???????????????: ???????????? SCADA/DMS'
                },
                legend: legendSetting,
                series: series,
                xAxis: {
                    name: 'Date',
                    categories: data['categories'],
                    tickInterval: 2,
                    tickmarkPlacement: 'on',
                },
                yAxis: {
                    labels: {
                        format: '{value}',
                        /*formatter: function() {
                            return format('#,###.', this.value);
                        },*/
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
