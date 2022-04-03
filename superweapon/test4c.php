
<!DOCTYPE html>
<html>
 <head>
  <title>How to return JSON Data from PHP Script using Ajax Jquery</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  #result {
   position: absolute;
   width: 100%;
   max-width:870px;
   cursor: pointer;
   overflow-y: auto;
   max-height: 400px;
   box-sizing: border-box;
   z-index: 1001;
  }
  .link-class:hover{
   background-color:#f1f1f1;
  }
  </style>
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <h2 align="center">How to return JSON Data from PHP Script using Ajax Jquery</h2>
   <h3 align="center">Search Employee Data</h3><br />

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

   <div class="table-responsive" id="employee_details" style="display:none">
   <table class="table table-bordered">
    <tr>
     <td width="10%" align="right"><b>Name</b></td>
     <td width="90%"><span id="employee_name"></span></td>
    </tr>
   </table>
   </div>

  </div>
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
    url:"testdata2b.php",
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
     $('#employee_details').css("display", "block");
     $('#employee_name').text(data.substation);
     console.log(data);
    }
   })
  }
  else
  {
   alert("Please fill all the filed!");
   $('#employee_details').css("display", "none");
  }
 });
});
</script>

<script src="substation_dropdown.js"></script>
