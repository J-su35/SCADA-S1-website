$(function(){
var authorOptions;
var equipmentOptions;

	$.getJSON('data/author.json',function(result){
		authorOptions += '<option value="">เลือก กฟฟ.</option>';
		$.each(result.author, function(i,Author) {
			//<option value='countrycode'>contryname</option>
			authorOptions+="<option value='"
			+Author.Br_name+
			"'>"
			+Author.Br_name+
			"</option>";
			 });
			 $('#Author').html(authorOptions);
	});

	$("#Author").change(function(){
	if($(this).val() == "กฟจ.เพชรบุรี"){
			$.getJSON('data/create.json',function(result){
			$.each(result.PB, function(i,Equipment) {
				//<option value='stateCode'>stateName</option>
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);


				// work!
				// $(result.component).each(function(index,value){
				// console.log(value.EquipWork);
				// }

			});
		} else if ($(this).val() == "กฟส.บ้านแหลม"){
			$.getJSON('data/create.json',function(result){
			$.each(result.BanLaem, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.ท่ายาง"){
			$.getJSON('data/create.json',function(result){
			$.each(result.ThaYang, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.บ้านลาด"){
			$.getJSON('data/create.json',function(result){
			$.each(result.BanLat, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.เขาย้อย"){
			$.getJSON('data/create.json',function(result){
			$.each(result.KhaoYoi, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟจ.ราชบุรี"){
			$.getJSON('data/create.json',function(result){
			$.each(result.RB, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.ปากท่อ"){
			$.getJSON('data/create.json',function(result){
			$.each(result.PTH, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟจ.สมุทรสงคราม"){
			$.getJSON('data/create.json',function(result){
			$.each(result.SS, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.อัมพวา"){
			$.getJSON('data/create.json',function(result){
			$.each(result.AM, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.บางคนที"){
			$.getJSON('data/create.json',function(result){
			$.each(result.BangKhonthi, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟจ.ประจวบคีรีขันธ์"){
			$.getJSON('data/create.json',function(result){
			$.each(result.PD, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.ทับสะแก"){
			$.getJSON('data/create.json',function(result){
			$.each(result.ThapSakae, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.ทับสะแก"){
			$.getJSON('data/create.json',function(result){
			$.each(result.ThapSakae, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.กุยบุรี"){
			$.getJSON('data/create.json',function(result){
			$.each(result.KU, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟจ.ชุมพร"){
			$.getJSON('data/create.json',function(result){
			$.each(result.CP, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.ปากน้ำชุมพร"){
			$.getJSON('data/create.json',function(result){
			$.each(result.PakNamCP, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟจ.ระนอง"){
			$.getJSON('data/create.json',function(result){
			$.each(result.RN, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟอ.หัวหิน"){
			$.getJSON('data/create.json',function(result){
			$.each(result.HH, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟอ.ปราณบุรี"){
			$.getJSON('data/create.json',function(result){
			$.each(result.PN, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟอ.โพธาราม"){
			$.getJSON('data/create.json',function(result){
			$.each(result.PTR, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.ดำเนินสะดวก"){
			$.getJSON('data/create.json',function(result){
			$.each(result.DN, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.ดอนไผ่"){
			$.getJSON('data/create.json',function(result){
			$.each(result.DonPhai, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.บางแพ"){
			$.getJSON('data/create.json',function(result){
			$.each(result.BangPhae, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟอ.ชะอำ"){
			$.getJSON('data/create.json',function(result){
			$.each(result.CA, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟอ.บางสะพาน"){
			$.getJSON('data/create.json',function(result){
			$.each(result.BSP, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟอ.จอมบึง"){
			$.getJSON('data/create.json',function(result){
			$.each(result.CBN, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.สวนผึ้ง"){
			$.getJSON('data/create.json',function(result){
			$.each(result.SP, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟอ.หลังสวน"){
			$.getJSON('data/create.json',function(result){
			$.each(result.LSN, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		} else if ($(this).val() == "กฟส.สวี"){
			$.getJSON('data/create.json',function(result){
			$.each(result.Sawi, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		}
		else {
			$.getJSON('data/create.json',function(result){
			$.each(result.TSE, function(i,Equipment) {
				equipmentOptions+="<option value='"
				+Equipment.EquipWork+
				"'>"
				+Equipment.EquipWork+
				"</option>";
				 });
				 $('#Equipment').html(equipmentOptions);
			});
		}
	});
});
