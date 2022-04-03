<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Load profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  


    <style>

        body {
            width: 550px;
            margin: 3rem auto;
        }

        #chart-container {
            width: 100%;
            height: auto;
        }

    </style>


</head>
<body>


    <div class="container"> 
        <form >
            <select name="sub" id="sub">
                <option value = "" >Choose Substation</option>
                <option value = "PTR" >โพธาราม 1</opion>
                <option value = "PTS" >โพธาราม 2</opion>
                <option value = "DNA" >ดำเนินสะดวก</opion>
                <option value = "SSA" >สมุทรสงคราม</opion>
                <option value = "CBN" >จอมบึง</opion>
                <option value = "RBA" >ราชบุรี 1</opion>
                <option value = "RBB" >ราชบุรี 2</opion>
                <option value = "RBC" >ราชบุรี 3 ถาวร</opion>
                <option value = "RBU" >ราชบุรี 3 ชั่วคราว</opion>
                <option value = "RIU" >นิคมอุตสาหกรรมราชบุรี</opion>
                <option value = "RNB" >ระนอง 2</opion>
            </select>
        </form>        
    </div>

<script>  
 $(document).ready(function(){  
      $('#sub').change(function(){  
           var substation = $(this).val();  
           $.ajax({  
                url:"data1.php",  
                method:"POST",  
                data:{substation:substation},  
                success:function(data){  
                     $('#graphCanvas').html(data);  
                }  
           });  
      });  
 });  
 </script>  

    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        $(document).ready(function() {
            showGraph();
        });

        function showGraph(){
            {
                $.post("data1.php", function(data) {
                    console.log(data);
                    let timeAxis = [];
                    let power = [];

                    for (let i in data) {
                        timeAxis.push(data[i].time);
                        power.push(data[i].subload);
                    }

                    let chartdata = {
                        labels: timeAxis,
                        datasets: [{
                                label: 'Load profile',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: power
                        }]
                    };

                    let graphTarget = $('#graphCanvas');
                    let thisGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata
                    })
                })
            }
        }
    </script>

</body>
</html>
