$(document).ready(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy'
    });

    /*$( "#datepicker2" ).datepicker({
        dateFormat: 'dd-mm-yy'
    });*/
    showCurve();

    $('#datepicker').change(function() {
        showCurve();       
    });

    function showCurve(){    
        $.getJSON('data.php',{date: $("#datepicker").val(), mode: '14total'}, function(data) {
            //alert(data['SubID']);
            var regions = ['S1', 'S2', 'S3'];
            var series = [];

            /*series.push({
                type: 'spline',
                name: 'Total load',
                data: data['values']['total'],
                visible: true
            });*/

            var provinceInfo = '';
            for (i = 0; i < regions.length; i++) {
                series.push({
                    type: 'areaspline',
                    name: regions[i],
                    data: data['values'][regions[i]],
                    visible: true
                });
                //provinceInfo += data['SubID'][i]+': '+data['Subname'][i]+'<br/>';
            }
            //$('#province-info').html(provinceInfo);

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
    }

    $("#select_form2").submit(function(){     
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
        
        $.getJSON('data.php',{date: $("#datepicker").val(),province: $("#province").val()}, function(data) {
            //alert(data['SubID']);
            var regions = data['SubID'];
            var pro = ['ชุมพร','ระนอง','นครศรีธรรมราช','สุราษฎร์ธานี','พังงา','ภูเก็ต','กระบี่','ตรัง','ยะลา','พัทลุง','สตูล','สงขล','ปัตตานี','นราธิวาส'];
            var series = [];

            series.push({
                type: 'spline',
                name: 'Total load',
                data: data['values']['total'],
                visible: true
            });

            var subInfo = '';
            for (i = 0; i < regions.length-2; i++) {
                series.push({
                    type: 'areaspline',
                    name: pro[i],
                    data: data['values'][regions[i]],
                    visible: true
                });
                subInfo += data['SubID'][i]+': '+data['Subname'][i]+'<br/>';
            }

            for (i = 0; i < 2; i++) {
                series.push({
                    type: 'areaspline',
                    name: pro[i+12],
                    data: data['values'][regions[i]],
                    visible: true
                });
                subInfo += data['SubID'][i]+': '+data['Subname'][i]+'<br/>';
            }

            series.push({
                type: 'spline',
                name: 'EGAT',
                data: data['values']['total'],
                visible: true
            });

            series.push({
                type: 'spline',
                name: 'Base Line',
                data: data['values']['total'],
                visible: true
            });

            series.push({
                type: 'spline',
                name: 'Compare',
                data: data['values']['total'],
                visible: true
            });

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
