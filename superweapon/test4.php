<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ab Load profile</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->

    <script type="text/javascript">
      $(document).ready(function(){
        $('input[type="submit"]').click(function(){
          var catRadio = $('#catRadio').val();
          var sub = $('#sub').val();
          var feeder = $('#feeder').val();
          var startDate = $('#startDate').val();
          var endDate = $('#endDate').val();

          if(sub !="" && feeder != "" && startDate !="" && endDate !="") {

          // var requestData = $('#mainForm').serialize();

          $.ajax({
            url:"data3.php",
            method:"POST",
            data:{
                catRadio: catRadio,
                sub: sub,
                feeder: feeder,
                startDate: startDate,
                endDate: endDate
            },
            // datatype: 'json',
            success: function(data){
              // highchartsPlot(data);
              console.log(data);
            }
            // success: function(data){
            //   var data = JSON.parse(data);
            //   if(data.statusCode==200){
            //
            //   } else if(data.statusCode==201){
            //     alert("Error occured!");
            //   }
            // }
          });
        } else {
          alert("Please fill all the filed!");
        }
        });
      });


        // function highchartsPlot(data){
        //   console.log(data);
        // }

    </script>

  </head>

  <style type="text/css">
    body{width: 800px;
      font-family: calibri;
      padding: 0;
      margin: 0 auto;
      }
    .frm{
      border:1px solid #7ddaff;
      background-color: #b4c8d0;
      margin: 0px auto;
      padding: 40px;
      border-radius: 4px;
    }
  .InputBox{
    border:#bdbdbd 1px solid;
    background-color: #fff;
    padding: 10px;
    border-radius: 4px;
    width: 50%;
  }
  .row{
    padding-bottom: 15px;
    padding-left: 150px;
  }

  #chart-container {
      width: 100%;
      height: auto;
  }

  </style>


  <body>
    <div class="frm">
      <h2>Load profile</h2>

      <form id="mainForm" name="mainForm" method="post">

        <div class="row">
          <br>
          <form id="catRadio">
            <input type="radio" name="category" value="subload" class="form-check-input"> MW
            <input type="radio" name="category" value="submvar" class="form-check-input"> MVar
            <input type="radio" name="category" value="kV" class="form-check-input"> kV
          </form>
        </div>
        <div class="row">

          <label>Substation</label><br>
          <select name="sub" id="sub" name="sub" class="InputBox">
            <option value="">Select Substation</option>
          </select>
        </div>

        <div class="row">
          <label>Feeder</label><br>
          <select name="feeder" id="feeder" name="feeder" class="InputBox">
            <option value="">Select Feeder</option>
          </select>
        </div>

        <div class="row">
          <form>
            <label for="startDate">Start:</label>
            <input type="date" id="startDate" name="startDate">
            <label for="endDate">End:</label>
            <input type="date" id="endDate" name="endDate">
            <input type="submit" value="Submit">
          </form>
        </div>
      </form>
    </div>


    <figure class="highcharts-figure">
      <div id="container"></div>
      <!-- <p class="highcharts-description">
          กราฟแสดงค่าโหลดรายวัน สฟฟ.ระนอง2 วันที่ 20 มีนาคม 2564
      </p> -->
    </figure>


  <script src="substation_dropdown.js"></script>

  </body>
</html>
