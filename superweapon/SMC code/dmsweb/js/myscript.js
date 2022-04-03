$(document).ready(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy'
    });

    $("select#area").change(function(){
        var id = $("select#area option:selected").attr('value');
        $.post("select_province.php", {id:id}, function(data){
            $("select#province").html(data);
        });
    });
    $("select#province").change(function(){
        var id = $("select#province option:selected").attr('value');
        $.post("select_substation.php", {id:id}, function(data){
            $("select#substation").html(data);
        });
    });

    //var myBtn = document.getElementById('show-chart');
    var chart;

    $("#select_form").submit(function(){     
        /*var options = {
            chart: {
                renderTo: 'load-chart',
                type: 'bar'
            },
            title: {
                text: 'Fruit Consumption'
            },
            xAxis: {
                categories: ['Apples', 'Bananas', 'Oranges']
            },
            yAxis: {
                title: {
                    text: 'Fruit eaten'
                }
            },
            series: [{
                name: 'Jane',
                data: [1, 0, 4]
            }, {
                name: 'John',
                data: [5, 7, 3]
            }]
        };
        var chart = new Highcharts.Chart(options);
        return false;*/
        var e = document.getElementById("province");
        var d = document.getElementById("datepicker");
        
        $.getJSON('data2.php',{date: $("#datepicker").val(),province: $("#province").val()}, function(data) {
            //alert(data['SubID']);
            var regions = data['SubID'];
            var series = [];

            series.push({
                type: 'spline',
                name: 'Total load',
                data: data['values']['total'],
                visible: true
            });

            var subInfo = '';
            for (i = 0; i < regions.length; i++) {
                series.push({
                    type: 'areaspline',
                    name: regions[i],
                    data: data['values'][regions[i]],
                    visible: false
                });
                subInfo += data['SubID'][i]+': '+data['Subname'][i]+'<br/>';
            }
            $('#substation-info').html(subInfo);

            $('#load-chart').highcharts({
                chart: {
                    renderTo: 'load-chart',
                    animation: { duration: 1000 },                    
                },
                title: {
                    text: 'โหลดรวมของจังหวัดในรอบ 24 ชม.',
                    //margin: 10
                },
                subtitle: {
                    //text: 'ที่มา: ระบบ SCADA/DMS'
                },
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
                        text: 'ปริมาณโหลดรวม (MW)',
                    }
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = this.x +' น.';
                        var sum = 0;

                        $.each(this.points, function(i, point) {
                            s += '<br/><span style="color: ' + point.series.color + ';">' + point.series.name + '</span>: <strong>'+ format('#,###.##', point.y) + ' MW</strong>';
                            if (point.series.name != 'Total load') {
                                sum += point.y;
                            }
                            else {
                                s += '<br/> ';
                            }
                        });

                        s += '<br/><br/>Area total: <strong>' + sum + ' MW</strong>';
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
        return false;
    });    
});
