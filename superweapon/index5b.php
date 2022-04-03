
<!DOCTYPE html>
<html>
 <head>
  <title>Ab Load profile</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

  <style>

  </style>
 </head>
 <body>
  <br /><br />
  <!-- <div class="container" style="width:900px;"> -->
  <div class="container">
   <h2 align="center">How to return JSON Data from PHP Script using Ajax Jquery</h2>
   <br />

   <div class="form-group" id="catRadio">
     <label class="form-check-label">
       <input type="radio" name="category" value="subload" required> MW
     </label>
     <label class="form-check-label">
       <input type="radio" name="category" value="submvar" > MVar
     </label>
     <label class="form-check-label">
       <input type="radio" name="category" value="kV" > kV
     </label>
   </div>

   <div class="row">
    <div class="col-md-3">
      <label>Substation</label>
      <select name="sub" id="sub" name="sub" class="form-control">
        <option value="">Select Substation</option>
      </select>
    </div>

     <div class="col-md-3">
       <label>Feeder</label>
       <select name="feeder" id="feeder" name="feeder" class="form-control">
         <option value="">Select Feeder</option>
       </select>
     </div>

     <div class="col-md-3">
         <label for="startDate">Start:</label>
         <input type="date" id="startDate" name="startDate" class="form-control">
     </div>

     <div class="col-md-3">
         <label for="endDate">End:</label>
         <input type="date" id="endDate" name="endDate" class="form-control">
     </div>
    </div>
    <br />

    <div class="row">
      <div class="col-md-4">
        <button type="button" name="search" id="search" class="btn btn-info">Search</button>
      </div>
    </div>
   </div>
   <br />

   <section class="container">
     <div class="container-fluid" id="allCards" style="display:none">
       <div class="row">
         <!-- <div class="col-md-3 mb-3">
           <div class="card text-white bg-primary mb-3 h-100">
             <div class="card-header">Power</div>
             <div class="card-body">
               <h5 class="card-title">Primary card title</h5>
               <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
         </div> -->

         <!-- <div class="col-md-3 mb-3">
           <div class="card text-white bg-primary mb-3 h-100">
             <div class="card-header">Reactive Power</div>
             <div class="card-body">
               <h5 class="card-title">Primary card title</h5>
               <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
         </div>

         <div class="col-md-3 mb-3">
           <div class="card text-white bg-primary mb-3 h-100">
             <div class="card-header">kV</div>
             <div class="card-body">
               <h5 class="card-title">Primary card title</h5>
               <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
         </div>

         <div class="col-md-3 mb-3">
           <div class="card text-white bg-primary mb-3 h-100">
             <div class="card-header">PF</div>
             <div class="card-body">
               <h5 class="card-title">Primary card title</h5>
               <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
         </div>
       </div>
     </div> -->

         <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-primary shadow h-100 py-2">
             <div class="card-header bg-primary">Power</div>
             <div class="card-body">
               <div class="row no-gutters align-items-center">
                 <div class="col mr-2">
                   <div class="test-xs font-weight-bold text-primary text-uppercase mb-1">Maximum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800"><span id="maxMW"></span></div>
                   <div class="test-xs font-weight-bold text-primary text-uppercase mb-1">Minimum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800"><span id="minMW"></span></div>
                   <div class="test-xs font-weight-bold text-primary text-uppercase mb-1">Average</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800"><span id="aveMW"></span></div>
                 </div>
               </div>
             </div>
           </div>
         </div>

         <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-info shadow h-100 py-2">
             <div class="card-header bg-info">Reactive Power</div>
             <div class="card-body">
               <div class="row no-gutters align-items-center">
                 <div class="col mr-2">
                   <div class="test-xs font-weight-bold text-info text-uppercase mb-1">Maximum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                   <div class="test-xs font-weight-bold text-info text-uppercase mb-1">Minimum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                   <div class="test-xs font-weight-bold text-info text-uppercase mb-1">Average</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                 </div>
               </div>
             </div>
           </div>
         </div>

         <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-primary shadow h-100 py-2">
             <div class="card-header bg-primary">Votage</div>
             <div class="card-body">
               <div class="row no-gutters align-items-center">
                 <div class="col mr-2">
                   <div class="test-xs font-weight-bold text-primary text-uppercase mb-1">Maximum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                   <div class="test-xs font-weight-bold text-primary text-uppercase mb-1">Minimum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                   <div class="test-xs font-weight-bold text-primary text-uppercase mb-1">Average</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                 </div>
               </div>
             </div>
           </div>
         </div>

         <div class="col-xl-3 col-md-6 mb-4">
           <div class="card border-left-info shadow h-100 py-2">
             <div class="card-header bg-info">PF</div>
             <div class="card-body">
               <div class="row no-gutters align-items-center">
                 <div class="col mr-2">
                   <div class="test-xs font-weight-bold text-info text-uppercase mb-1">Maximum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                   <div class="test-xs font-weight-bold text-info text-uppercase mb-1">Minimum</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                   <div class="test-xs font-weight-bold text-info text-uppercase mb-1">Average</div>
                   <div class="h5 mb-0 font-weight-bold text-grey-800">$4000</div>
                 </div>
               </div>
             </div>
           </div>
         </div>

   </section>



   <figure class="highcharts-figure">
     <div id="chart-container"></div>
   </figure>

 </body>
</html>

<script>
$(document).ready(function(){
 $('#search').click(function(){
  var catRadio = $('input[type="radio"]').val();
  var sub= $('#sub').val();
  var feeder = $('#feeder').val();
  var startDate = $('#startDate').val();
  var endDate = $('#endDate').val();

  if(catRadio != '' && sub != '' && feeder != '' && startDate != '' && endDate != '')
  {
   $.ajax({
    url:"testdata2c.php",
    method:"POST",
    data:{sub:sub,
          feeder:feeder,
          catRadio:catRadio,
          startDate:startDate,
          endDate:endDate
         },
    dataType:"JSON",
    success:function(data)
    {
     // console.log(data);
     $('#allCards').show();
     highchartsPlot(data);
    }
   })
  }
  else
  {
   alert("Please fill all the filed!");
  }
 });
});

function highchartsPlot(data){
  console.log(data);

  // let com = "";
  // for (let x in data) {
  //   com += data[x].subload;
  // }

  // console.log(com);

  let timeAxis = [];
  let yAxis = [];
  let dataType = $('input[type="radio"]').val();
  // console.log(dataType);
  if (dataType == "subload") {
    for (let i in data) {
      timeAxis.push(data[i].time);
      yAxis.push(data[i].subload);
    }
    // console.log(yAxis);
    // console.log(yAxis.length);
    // console.log(typeof yAxis);

    var maxValue = Math.max(...yAxis);
    document.getElementById("maxMW").innerHTML = maxValue + " MW";

    console.log(Math.max(...yAxis));
    console.log(Math.min(...yAxis));

    // let xe = yAxis.length;

    function meanArray(yArray) {
      let y = 0;
      // let meanA = 0;
      for (let x in yArray) {
        y += Number(yArray[x]);
      }
      return y/yArray.length;
    }
    // let x1 = meanArray(yAxis, xe);
    let x1 = meanArray(yAxis);

    console.log(x1);

      // let y = 0;
      //
      // for (let x in yAxis) {
      //   y += Number(yAxis[x]);
      // }
      // let x2 = y/xe;
      // console.log(x2);



  }

  var myChart = Highcharts.chart('chart-container', {

  chart: {
    type: 'area'
  },
  title: {
    text: 'Daily Load Curve'
  },
  subtitle: {
    text: 'Sources: SMC'
  },
  xAxis: {
    categories: timeAxis,
    allowDecimals: false
    // labels: {
    //   formatter: function () {
    //     return this.value; // clean, unformatted number for year
    //   }
    // }
  },
  yAxis: {
    title: {
      text: 'Power (MW)'
    },
    labels: {
      formatter: function () {
        return this.value;
      }
    }
    },
  tooltip: {
    pointFormat: '{point.y} MW'
  },
  plotOptions: {
    area: {
      marker: {
        enabled: false,
        symbol: 'circle',
        radius: 2,
        states: {
          hover: {
            enabled: true
          }
        }
      }
    }
  },
  series: [{
    name: 'MW',
    data: yAxis
  }]
});
}
</script>

<script src="substation_dropdown.js"></script>
