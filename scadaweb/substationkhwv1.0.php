<?php
  $page = "รายงานการอ่านมาตรวัดไฟฟ้า";
  include_once 'header7.php';
  require_once 'process8.php';
?>

<?php
  $mysqli = new mysqli('sql113.epizy.com', 'epiz_24636187', 'uONrYWxJLD', 'epiz_24636187_login') or die(mysqli_error($mysqli));
  $result = $mysqli->query("SELECT * FROM subkhw") or die($mysqli->error);
?>

<!-- Session message section -->
<?php if (isset($_SESSION['message'])): ?>
  <div class="alert alert-<?=$_SESSION['msg_type']?>">
    <?php
      echo $_SESSION['message'];
      unset($_SESSION['message']);
     ?>
  </div>
<?php endif ?>
<!-- Session message section end -->

  <section>
    <div class="text-center mt-3">
      <h2>ลงข้อมูลมาตรวัดไฟฟ้าประจำเดือน</h2>
    </div>

    <div class="container-fluid">
      <form action="process8.php" method="post">
        <div class="form-row">

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="form-group col-md-6">
          <label for="month">เดือน</label>
          <select name="month" id="month" class="form-control" required>
            <option value=""></option>
            <option value="มกราคม">มกราคม</option>
            <option value="กุมภาพันธ์">กุมภาพันธ์</option>
            <option value="มีนาคม">มีนาคม</option>
            <option value="เมษายน">เมษายน</option>
            <option value="พฤษภาคม">พฤษภาคม</option>
            <option value="มิถุนายน">มิถุนายน</option>
            <option value="กรกฎาคม">กรกฎาคม</option>
            <option value="สิงหาคม">สิงหาคม</option>
            <option value="กันยายน">กันยายน</option>
            <option value="ตุลาคม">ตุลาคม</option>
            <option value="พฤศจิกายน">พฤศจิกายน</option>
            <option value="ธันวาคม">ธันวาคม</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="yeartxt">พ.ศ.</label>
          <input type="text" name="year" id="yeartxt" class="form-control" disabled>
        </div>
        <div class="form-group col-md-6">
            <label for="subName">สฟฟ.</label>
            <select name="substaion" id="subName" class="form-control" required>
              <option value=""></option>
              <option value="จอมบึง">จอมบึง</option>
              <option value="ชะอำ 1">ชะอำ 1</option>
              <option value="ชะอำ 2">ชะอำ 2</option>
              <option value="ชะอำ 3">ชะอำ 3</option>
              <option value="ปากท่อ">ปากท่อ</option>
              <option value="โพธาราม">โพธาราม</option>
              <option value="ราชบุรี 2 ลานไก">ราชบุรี 2 ลานไก</option>
              <option value="ราชบุรี 2">ราชบุรี 2</option>
              <option value="ราชบุรี 3 (ชั่วคราว)">ราชบุรี 3 (ชั่วคราว)</option>
              <option value="ราชบุรี 3 (ถาวร)">ราชบุรี 3 (ถาวร)</option>
              <option value="หัวหิน 2">หัวหิน 2</option>
              <option value="หัวหิน 3">หัวหิน 3</option>
              <option value="หัวหิน 4">หัวหิน 4</option>
              <option value="ดำเนินสะดวก">ดำเนินสะดวก</option>
              <option value="สวนผึ้ง">สวนผึ้ง</option>
            </select>
          </div>
          <div class="form-group col-md-6 mt-2">
            <br><button type="button" class="btn btn-primary" onclick="chooseSub()">เลือก</button>
          </div>
          <div class="form-group col-md-6">
            <label for="voltage">แรงดัน</label>
            <input type="text" name="voltage" id="voltage" class="form-control" disabled>
          </div>
          <div class="form-group col-md-6">
            <label>เวลาอ่าน</label>
            <input type="time" name="read_time" id="read_time" class="form-control" required>
          </div>
          <div class="form-group col-md-6">
            <label>วันที่อ่าน</label>
            <input type="date" name="read_date" id="read_date" class="form-control" required>
          </div>
        </div>

        <fieldset class="form-group">
          <legend id="legend0"></legend>

          <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
          <label for="F1_current_Exunit">Export (+)</label>
          <input type="number" name="F1_current_Exunit" id = "F1_current_Exunit" class="form-control">
          <label for="F1_current_Imunit">Import (-)</label>
          <input type="number" name="F1_current_Imunit" id ="F1_current_Imunit" class="form-control">


          <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
          <label for="F1_last_Exunit">Export (+)</label>
          <input type="number" name="F1_last_Exunit" id ="F1_last_Exunit" class="form-control">
          <label for="F1_last_Imunit">Import (-)</label>
          <input type="number" name="F1_last_Imunit" id="F1_last_Imunit" class="form-control">

          <label for="F1_different">ผลต่าง</label>
          <input type="text" name="F1_different" id ="F1_different" class="form-control" disabled><br>
          <label for="factor0">ตัวคูณ</label>
          <select name="F0_factor" id="factor0" class"form-control" required>
            <option value=""></option>
            <option value="1">1</option>
            <option value="1000">1000</option>
            <option value="1000000">1000000</option>
          </select><br>

          <label for="F1_summation">ผลลัพธ์</label>
          <input type="text" name="F1_summation" id="F1_summation" class="form-control" disabled>
        </fieldset>

        <fieldset class="form-group">
          <legend id="legend1"></legend>

          <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
          <label for="F2_current_Exunit">Export (+)</label>
          <input type="number" name="F2_currnet_Exunit" id="F2_current_Exunit" class="form-control">
          <label for="F2_current_Imunit">Import (-)</label>
          <input type="number" name="F2_current_Imunit" id="F2_current_Imunit" class="form-control">

          <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
          <label for="F2_last_Exunit">Export (+)</label>
          <input type="number" name="F2_last_Exunit" id="F2_last_Exunit" class="form-control">
          <label for="F2_last_Imunit">Import (-)</label>
          <input type="number" name="F2_last_Imunit" id="F2_last_Imunit" class="form-control">

          <label for="F2_different">ผลต่าง</label>
          <input type="text" name="F2_different" id="F2_different" class="form-control" disabled>
          <label for="factor1">ตัวคูณ</label>
          <select name="F1_factor" id="factor1" class="form-control" required>
            <option value=""></option>
            <option value="1">1</option>
            <option value="1000">1000</option>
            <option value="1000000">1000000</option>
          </select><br>

          <label for="F2_summation">ผลลัพธ์</label>
          <input type="text" name="F2_summation" id="F2_summation" class="form-control" disabled><br>
        </fieldset>


        <fieldset class="form-group">
          <legend id="legend2"></legend>

          <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
          <label for="F3_current_Exunit">Export (+)</label>
          <input type="number" name="F3_current_Exunit" class="form-control" id="F3_current_Exunit">
          <label for="F3_current_Imunit">Import (-)</label>
          <input type="number" name="F3_current_Imunit" class="form-control" id="F3_current_Imunit">

          <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
          <label for="F3_last_Exunit">Export (+)</label>
          <input type="number" name="F3_last_Exunit" class="form-control" id="F3_last_Exunit">
          <label for="F3_last_Imunit">Import (-)</label>
          <input type="number" name="F3_last_Imunit" class="form-control" id="F3_last_Imunit">

          <label for="F3_different">ผลต่าง</label>
          <input type="text" name="F3_different" id="F3_different" class="form-control" disabled>

          <label for="factor2">ตัวคูณ</label>
          <select name="F2_factor" id="factor2" class="form-control" required>
            <option value=""></option>
            <option value="1">1</option>
            <option value="1000">1000</option>
            <option value="1000000">1000000</option>
          </select><br>
          <label for="F3_summation">ผลลัพธ์</label>
          <input type="text" name="F3_summation" id="F3_summation" class="form-control" disabled>
        </fieldset>

      <fieldset class="form-group">
          <legend id="legend3"></legend>

          <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
          <label for="F4_current_Exunit">Export (+)</label>
          <input type="number" name="F4_current_Exunit" class="form-control" id="F4_current_Exunit">
          <label for="F4_current_Imunit">Import (-)</label>
          <input type="number" name="F4_current_Imunit" class="form-control" id="F4_current_Imunit">

          <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
          <label for="F4_last_Exunit">Export (+)</label>
          <input type="number" name="F4_last_Exunit" class="form-control" id="F4_last_Exunit">
          <label for="F4_last_Imunit">Import (-)</label>
          <input type="number" name="F4_last_Imunit" class="form-control" id="F4_last_Imunit">

          <label for="F4_different">ผลต่าง</label>
          <input type="text" name="F4_different" id="F4_different" class="form-control" disabled>
          <label for="factor3">ตัวคูณ</label>
          <select name="F3_factor" id="factor3" class="form-control" required>
            <option value=""></option>
            <option value="1">1</option>
            <option value="1000">1000</option>
            <option value="1000000">1000000</option>
          </select><br>
          <label for="F4_summation">ผลลัพธ์</label>
          <input type="text" name="F4_summation" id="F4_summation" class="form-control" disabled>
        </fieldset>

      <fieldset class="form-group">
          <legend id="legend4"></legend>

          <label>ตัวเลขที่อ่านได้ในเดือนนี้</label><br>
          <label for="F5_current_Exunit">Export (+)</label>
          <input type="number" name="F5_current_Exunit" class="form-control" id="F5_current_Exunit">
          <label for="F5_current_Imunit">Import (-)</label>
          <input type="number" name="F5_current_Imunit" class="form-control" id="F5_current_Imunit">

          <label>ตัวเลขที่อ่านได้ในเดือนก่อน</label><br>
          <label for="F5_last_Exunit">Export (+)</label>
          <input type="number" name="F5_last_Exunit" class="form-control" id="F5_last_Exunit">
          <label for="F5_last_Imunit">Import (-)</label>
          <input type="number" name="F5_last_Imunit" class="form-control" id="F5_last_Imunit">

          <label for="F5_different">ผลต่าง</label>
          <input type="text" name="F5_different" id="F5_different" class="form-control" disabled>
          <label for="factor4">ตัวคูณ</label>
          <select name="F4_factor" id="factor4" class="form-control" required>
            <option value=""></option>
            <option value="1">1</option>
            <option value="1000">1000</option>
            <option value="1000000">1000000</option>
          </select><br>
          <label for="F5_summatio">ผลลัพธ์</label>
          <input type="text" name="F5_summation" id="F5_summation" class="form-control" disabled>
        </fieldset>

      <div class="form-group row">
        <label class="col-sm-3 col-form-check-label">การถ่ายเทโหลดระหว่าง Incoming</label>
        <div class="col-sm-9">
          <div class="form-check form-check-inline">
            <input type="radio" name="loadtransfer_incoming" class="form-check-input" value="มี">
            <label class="form-check-label" for="loadtransfer_incoming">มี</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="loadtransfer_incoming" class="form-check-input" value="ไม่มี">
            <label class="form-check-label" for="loadtransfer_incoming">ไม่มี</label>
          </div>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-3 col-form-check-label">การถ่ายเทโหลดระหว่าง Feeder</label>
        <div class="col-sm-9">
          <div class="form-check form-check-inline">
            <input type="radio" name="loadtransfer_feeder" class="form-check-input" value="Yes">
            <label class="form-check-label" for="loadtransfer_feeder">มี</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" name="loadtransfer_feeder" class="form-check-input" value="No">
            <label class="form-check-label" for="loadtransfer_feeder">ไม่มี</label>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="sumIncoming">พลังงานไฟฟ้า Incoming</label>
        <input type="text" name="sumIncoming_energy" id="sumIncoming" class="form-control" disabled>
        <label for="sumFeeder">พลังงานไฟฟ้า Feeder</label>
        <input type="text" name="sumFeeder_energy" id="sumFeeder" class="form-control" disabled>
        <label for="txtRemark">หมายเหตุ</label>
        <textarea name="message" rows="5" cols="30" id="txtRemark" class="form-control"></textarea><br>
        <label for="operatorName">ผู้ลงข้อมูล</label>
        <input type="text" name="operator_name" id="operatorName" class="form-control mb-3"><br>

        <button type="button" class="btn btn-primary" onclick="processing()">ประมวลผล</button>

        <?php if($_SESSION['username']=='scadaadmin'): ?>
          <button type="submit" name="save" class="btn btn-success">บันทึกข้อมูล</button>
        <?php endif; ?>
      </div>
      </form>
    </div>

    <script>
      function chooseSub() {

        let yearNow = new Date();
        document.getElementById("yeartxt").value = yearNow.getFullYear()+543;

        var jsonSub = [{Name:"จอมบึง", voltage:"115/22 kV", factor:1000, cbName:["CBN1YB-01", "CBN2YB-01", "CBN3YB-01", "CBN1BVB-01", "CBN2BVB-01", "CBN1VB-01", "CBN2VB-01", "CBN3VB-01", "CBN4VB-01", "CBN5VB-01", "CBN6VB-01", "CBN7VB-01", "CBN8VB-01", "CBN9VB-01", "CBN10VB-01", "", "", "", ""]},
                      {Name:"ชะอำ 1", voltage:"22 kV", factor:1000, cbName:["CAA1BVB", "CAA2BVB-01", "CAA1B-01", "CAA2B-01", "CAA3B-01", "CAA4B-01", "CAA5B-01", "CAA6B-01", "CAA7B-01", "CAA7B-01", "CAA8B-01", "CAA9B-01", "CAA10B-01", "", "", "", "", "", ""]},
                      {Name:"ชะอำ 2", voltage:"115/22 kV", factor:1000, cbName:["CAB1YB-01", "CAB2YB-01", "CAB3YB-01", "CAB4YB-01", "CAB1BVB-01", "CAB2BVB-01", "CAB1VB-01", "CAB2VB-01", "CAB3VB-01", "CAB4VB-01", "CAB5VB-01", "CAB6VB-01", "CAB7VB-01", "CAB8VB-01", "CAB9VB-01", "CAB10VB-01", "", "", ""]},
                      {Name:"ชะอำ 3", voltage:"115/22 kV", factor:1000, cbName:["CAU1YB-01", "CAU1BVB-01", "CAU1VB-01", "CAU2VB-01", "CAU3VB-01", "CAU4VB-01", "CAU5VB-01", "", "", "", "", "", "", "", "", "", "", "", ""]},
                      {Name:"ปากท่อ", voltage:"115/22 kV", factor:1000, cbName:["PTH2YB-01", "PTH3YB-01", "PTH4YB-01", "PTH5YB-01", "PTH1BVB-01", "PTH2BVB-01", "PTH1VB-01", "PTH2VB-01", "PTH3VB-01", "PTH4VB-01", "PTH5VB-01", "PTH6VB-01", "PTH7VB-01", "PTH8VB-01", "PTH9VB-01", "PTH10VB-01", "", "", ""]},
                      {Name:"โพธาราม", voltage:"115/22 kV", factor:1000, cbName:["PTR2YB-01", "PTR3YB-01", "PTR4YB-01", "PTR5YB-01", "PTR6YB-01", "PTR7YB-01", "PTR8YB-01", "PTR1BVB-01", "PTR2BVB-01", "PTR1VB-01", "PTR2VB-01", "PTR3VB-01", "PTR4VB-01", "PTR5VB-01", "PTR6VB-01", "PTR7VB-01", "PTR8VB-01", "PTR9VB-01", "PTR10VB-01"]},
                      {Name:"ราชบุรี 2 ลานไก", voltage:"115 kV", factor:1, cbName:["RBB1YB-01", "RBB2YB-01", "RBB3YB-01", "RBB4YB-01", "RBB5YB-01", "RBB6YB-01", "RBB7YB-01", "", "", "", "", "", "", "", "", "", "", "", ""]},
                      {Name:"ราชบุรี 2", voltage:"115/22 kV", factor:1000, cbName:["RBB1BVB-01", "RBB2BVB-01", "RBB1VB-01", "RBB2VB-01", "RBB3VB-01", "RBB4VB-01", "RBB5VB-01", "RBB6VB-01", "RBB7VB-01", "RBB8VB-01", "RBB9VB-01", "RBBBVB-01", "", "", "", "", "", "", ""]},
                      {Name:"ราชบุรี 3 (ชั่วคราว)", voltage:"115/22 kV", factor:1000, cbName:["RBU1YB-01", "RBU1VB-01", "RBU2VB-01", "RBU3VB-01", "RBU4VB-01", "RBU5VB-01", "", "", "", "", "", "", "", "", "", "", "", "", ""]},
                      {Name:"ราชบุรี 3 (ถาวร)", voltage:"22 kV", factor:1000, cbName:["RBU1YB-01", "RBU1VB-01", "RBU2VB-01", "RBU3VB-01", "RBU4VB-01", "RBU5VB-01", "", "", "", "", "", "", "", "", "", "", "", "", ""]},
                      {Name:"หัวหิน 2", voltage:"115/22 kV", factor:1000, cbName:["HUB2YB-01", "HUB3YB-01", "HUB4YB-01", "HUB5YB-01", "HUB6YB-01", "HUB1BVB-01", "HUB2BVB-01", "HUB1VB-01", "HUB2VB-01", "HUB3VB-01", "HUB4VB-01", "HUB5VB-01", "HUB6VB-01", "HUB7VB-01", "HUB8VB-01", "HUB9VB-01", "HUB10VB-01", "", ""]},
                      {Name:"หัวหิน 3", voltage:"115/22 kV", factor:1000, cbName:["HUC1YB-01", "HUC3YB-01", "HUC1BVB-01", "HUC2BVB-01", "HUC1VB-01", "HUC2VB-01", "HUC3VB-01", "HUC4VB-01", "HUC5VB-01", "HUC6VB-01", "HUC7VB-01", "HUC8VB-01", "HUC9VB-01", "HUC10VB-01", "", "", "", "", ""]},
                      {Name:"หัวหิน 4", voltage:"115/22 kV", factor:1000, cbName:["HUU1YB-01", "HUU1BVB-01", "HUU1VB-01", "HUU2VB-01", "HUU3VB-01", "HUU4VB-01", "HUU5VB-01", "", "", "", "", "", "", "", "", "", "", "", ""]},
                      {Name:"ดำเนินสะดวก", voltage:"115/22 kV", factor:1000, cbName:["DNA1YB-01", "DNA2YB-01", "DNA3YB-01", "DNA4YB-01", "DNA1BVB-01", "DNA2BVB-01", "DNA3VB-01", "DNA4VB-01", "DNA5VB-01", "DNA6VB-01", "DNA7VB-01", "DNA8VB-01", "DNA9VB-01", "DNA10VB-01", "", "", "", "", ""]},
                      {Name:"สวนผึ้ง", voltage:"115/22 kV", factor:1, cbName:["XPU1YB-01", "XPU1BR-01", "XPU2BR-01", "XPU3BR-01", "XPU4BR-01", "", "", "", "", "", "", "", "", "", "", "", "", "", ""]}
                      ];

        var sub = document.getElementById("subName").value;
        let i, j;
        for (i = 0; i < 15; i++) {
          if (sub == jsonSub[i].Name) {
            document.getElementById("voltage").value = jsonSub[i].voltage;
            for (j=0; j < 5; j++) {
              document.getElementById("legend"+[j]).appendChild(document.createTextNode(jsonSub[i].cbName[j]));
              document.getElementById("factor"+[j]).value = jsonSub[i].factor;
            }
          }
       }
     }

     function processing() {
       var sumFeeder = 0;
       // console.log(document.getElementById("F"+[k]+"_current_Exunit").value);

        for (let k = 1; k < 6; k++) {
          let a = document.getElementById("F"+[k]+"_current_Exunit").value;
          let b = document.getElementById("F"+[k]+"_current_Imunit").value;
          let c = document.getElementById("F"+[k]+"_last_Exunit").value;
          let d = document.getElementById("F"+[k]+"_last_Imunit").value;

          let factor = document.getElementById("factor"+[k-1]).value;

          document.getElementById("F"+[k]+"_different").value = Math.abs(a - b) - Math.abs(c - d);

          document.getElementById("F"+[k]+"_summation").value = factor * (document.getElementById("F"+[k]+"_different").value);
         }

        for (let j = 2; j <6; j++) {
          sumFeeder += parseInt(document.getElementById("F"+[j]+"_summation").value);
        }
         document.getElementById("sumFeeder").value = sumFeeder;
         document.getElementById("sumIncoming").value = document.getElementById("F"+[1]+"_summation").value;
     }


    </script>


</section>

<?php
  require "footer.php";
?>
