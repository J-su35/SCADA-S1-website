<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Load profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
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
      <form>
        <input type="radio" id="option1" name="option" value="MW">
        <label for="male">MW</label><br>
        <input type="radio" id="option2" name="option" value="MVAR">
        <label for="female">MVAR</label><br>
        <input type="radio" id="option3" name="option" value="kV">
        <label for="other">kV</label>
      </form>
    </div>

    <div class="container">
        <form >
          <label>Subststion</label><br>
            <select name="sub" id="sub">
              <option value = "" >select substation</option>
              <option value = "SSA" >สมุทรสงคราม</option>
              <option value = "DNA" >ดำเนินสะดวก</option>
              <option value = "PTR" >โพธาราม 1</option>
              <option value = "PTS" >โพธาราม 2</option>
              <option value = "RIU" >นิคมอุตสาหกรรมราชบุรี (ชั่วคราว)</option>
              <option value = "RBA" >ราชบุรี 1 (ชั่วคราว)</option>
              <option value = "RBB_HV" >ราชบุรี 2 (ลานไก 115 เควี)</option>
              <option value = "RBB" >ราชบุรี 2</option>
              <option value = "RBC" >ราชบุรี 3</option>
              <option value = "RBU" >ราชบุรี 3 (ชั่วคราว)</option>
              <option value = "CBN" >จอมบึง</option>
              <option value = "XPU" >สวนผึ้ง (ชั่วคราว)</option>
              <option value = "PTH" >ปากท่อ</option>
              <option value = "KHY" >เขาย้อย 1</option>
              <option value = "KHZ" >เขาย้อย 2</option>
              <option value = "PBA" >เพชรบุรี 1</option>
              <option value = "PBB" >เพชรบุรี 2</option>
              <option value = "CAA" >ชะอำ 1</option>
              <option value = "CAB" >ชะอำ 2</option>
              <option value = "CAU" >ชะอำ 3 (ชั่วคราว)</option>
              <option value = "KDA" >แก่งกระจาน (ชั่วคราว)</option>
              <option value = "HUB" >หัวหิน 2</option>
              <option value = "HUC" >หัวหิน 3</option>
              <option value = "HUU" >หัวหิน 4 (ชั่วคราว)</option>
              <option value = "PNA" >ปราณบุรี</option>
              <option value = "KUA" >กุยบุรี</option>
              <option value = "PDA" >ประจวบคีรีขันธ์</option>
              <option value = "BSP" >บางสะพาน 1</option>
              <option value = "BSR" >บางสะพาน 2</option>
              <option value = "TSE" >ท่าแซะ</option>
              <option value = "CPA" >ชุมพร 1</option>
              <option value = "CPB" >ชุมพร 2</option>
              <option value = "LSA" >หลังสวน</option>
              <option value = "QTA" >ปะทิว</option>
              <option value = "RNA" >ระนอง 1</option>
              <option value = "RNB" >ระนอง 2</option>
            </select>
        </form>
    </div>

    <div class="container">
        <label>Feeder</label><br>
        <select name="feeder" id="feeder">
          <option value="">Select substation first</option>
        </select>
      </div>

    <div class="container">
      <form><br/>
        <input type="date" id="dateInput" name="dateInput">
      </form>
    </div>

<script>
//  $(document).ready(function(){
//       $('#sub').change(function(){
//            var substation = $(this).val();
//            $.ajax({
//                 url:"data1.php",
//                 method:"POST",
//                 data:{substation:substation},
//                 success:function(data){
//                      $('#graphCanvas').html(data);
//                 }
//            });
//       });
//  });
 </script>

    <!-- <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div> -->


    <!-- <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->
    <script>
        // $(document).ready(function() {
        //     showGraph();
        // });

        // function showGraph(){
        //     {
        //         $.post("data1.php", function(data) {
        //             console.log(data);
        //             let timeAxis = [];
        //             let power = [];

        //             for (let i in data) {
        //                 timeAxis.push(data[i].time);
        //                 power.push(data[i].subload);
        //             }

        //             let chartdata = {
        //                 labels: timeAxis,
        //                 datasets: [{
        //                         label: 'Load profile',
        //                         backgroundColor: '#49e2ff',
        //                         borderColor: '#46d5f1',
        //                         hoverBackgroundColor: '#CCCCCC',
        //                         hoverBorderColor: '#666666',
        //                         data: power
        //                 }]
        //             };

        //             let graphTarget = $('#graphCanvas');
        //             let thisGraph = new Chart(graphTarget, {
        //                 type: 'line',
        //                 data: chartdata
        //             })
        //         })
        //     }
        // }
    </script>

    <script src="dependent_dropdown.js"></script>

</body>
</html>
