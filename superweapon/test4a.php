
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
   <div class="row">
    <div class="col-md-4">
     <select name="substation" id="sub" class="form-control">
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
    </div>
    <div class="col-md-4">
     <button type="button" name="search" id="search" class="btn btn-info">Search</button>
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
  var id= $('#sub').val();
  if(id != '')
  {
   $.ajax({
    url:"testdata2.php",
    method:"POST",
    data:{id:id},
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
   alert("Please Select Substation");
   $('#employee_details').css("display", "none");
  }
 });
});
</script>
