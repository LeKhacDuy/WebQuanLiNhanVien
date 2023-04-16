// ví dụ sử dụng javascript thuần
/* window.addEventListener("load", () => {
	let title = document.querySelector("h3");

	title.onmouseover = () => {
		title.style.color = "deeppink";
	};

	title.addEventListener("mouseleave", () => {
		title.style.color = "black";
	});
}); */

// ví dụ sử dụng jquery
/* $(document).ready(() => {
	$("#test").on("click", () => {
		$("h3").html("jQuery đã hoạt động");
	});
}); */
// phòng ban
// thêm phòng ban
$(document).on('click','#btn-themPB',function(e) {
	//let data = $("#form-themPB").serialize();
	if(validatePB()==true) {
		let myForm = document.getElementById('form-themPB');
	let form_data = new FormData(myForm);

	$.ajax({
		url: "../api/phongban/themPB.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
	}
	else{
		var errorPb=document.getElementById('errorPb')
		e.preventDefault();
		errorPb.innerHTML="Bạn phải điền đầy đủ thông tin !!!"

	}
});

// sửa phòng ban
function suaPB(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);

	/* for (var value of form_data.values()) {
		console.log(value);
	 }
	 return false; */
	$.ajax({
		url: "../api/phongban/suaPB.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}

// Xóa phòng ban
function xoaPB(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/phongban/xoaPB.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {

			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}



// nhân viên
// thêm nhân viên
$(document).on('click','#btn-themNV',function(e) {

	if(validateNV()==true){
		let myForm = document.getElementById('form-themNV');
		let form_data = new FormData(myForm);

		$.ajax({
			url: "../api/nhanvien/themNV.php",
			data: form_data,
			type: "post",	
			dataType:"JSON",
			processData: false,
			contentType: false,
			success: function (dataR) {
				if(dataR.code == 0){
					alert(dataR.error);
				}else {
					alert(dataR.data);
				}

				location.reload();
			}
		
		});
		location.reload();
	}
	else{
		var error=document.getElementById('error')
		e.preventDefault();
		error.innerHTML="Bạn phải điền đầy đủ thông tin !!!"
	}
  	
	
});

// Xóa nhân viên

function xoaNV(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/nhanvien/xoaNV.php",
		data: form_data,
		type: "post",
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}

// reset mật khẩu
function resetMK(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/nhanvien/resetMK.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}

// task trưởng phòng
// task
// tạo task
$(document).on('click','#btn-taoTask',function(e) {
	if(validatetaotask()==true){
		//let data = $("#form-taoTask").serialize();
		let myForm = document.getElementById('form-taoTask');
		let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/task/truongphong/taoTask.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
	}
	else{
		var errortaotask=document.getElementById('errortaotask')
		e.preventDefault();
		errortaotask.innerHTML="Bạn phải điền đầy đủ thông tin !!!"

	}
});

// Hủy task

function huyTask(form){
	/* let data = $(form).serialize(); */
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/task/truongphong/huyTask.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}
// reject task
function rejectTask(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/task/truongphong/rejectTask.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}
// approve task
function approveTask(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);

	$.ajax({
		url: "../api/task/truongphong/approveTask.php",
		data: form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {

			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

		}
		
	}); 
}

//task nhân viên
//task
// start task
function startTask(form){
	let data = $(form).serialize();
	$.ajax({
		url: "../api/task/nhanvien/startTask.php",
		data: data,
		type: "post",	
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			/* if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}
 */
			location.reload();
		}
		
	});
}

// chi tiết task
// submit task
$(document).on('click','#btn-submit-task',function(e) {
	if(validatesubmittask()==true){
		let myForm = document.getElementById('form-submit-task');
	let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/task/nhanvien/submitTask.php",
		data:  form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
	}
	else{
		var errorsubmit=document.getElementById('errorsubmit')
		e.preventDefault();
		errorsubmit.innerHTML="Bạn phải điền đầy đủ thông tin !!!"

	}
});

// nghỉ phép
// giám đốc



// trưởng phòng
// không duyệt đơn
function khongDuyet(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);

	$.ajax({
		url: "../api/nghiphep/khongDuyet.php",
		data: form_data,
		type: "post",
		dataType:"JSON",
		processData: false,
		contentType: false,	
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}

// duyệt đơn
function duyet(form){
	let myForm = document.getElementById(form);
	let form_data = new FormData(myForm);

	$.ajax({
		url: "../api/nghiphep/duyetDon.php",
		data: form_data,
		type: "post",
		dataType:"JSON",
		processData: false,
		contentType: false,	
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
}
// nhân viên
// nộp đơn 
$(document).on('click','#btn-nop-don',function(e) {
	if(validatengaynghi()==true){
		let myForm = document.getElementById('form-nop-don');
	let form_data = new FormData(myForm);
	$.ajax({
		url: "../api/nghiphep/nopDon.php",
		data:  form_data,
		type: "post",	
		dataType:"JSON",
		processData: false,
		contentType: false,
		success: function (dataR) {
			/* let dt = JSON.parse(data); */
			if(dataR.code == 0){
				alert(dataR.error);
			}else {
				alert(dataR.data);
			}

			location.reload();
		}
		
	});
	}
	else{
		var errorngaynghi=document.getElementById('errorngaynghi')
		e.preventDefault();
		errorngaynghi.innerHTML="Bạn phải điền đầy đủ thông tin !!!"

	}
});
//validate nhan vien
function validateNV(){
	var TenNV=document.getElementById('TenNV');
	var TenTK=document.getElementById('TenTK');
	var dcmail=document.getElementById('dcmail');
	var luong=document.getElementById('Luong');
	var mapb=document.getElementById('mapb')
	if(TenNV.value == null||TenNV.value==''){
		return false;
	}
	else if(TenTK.value==null||TenTK.value.length < 6){
		alert("Tài khoản phải >= 6 kí tự")
		return false;
	}
	else if(dcmail.value==null||dcmail.value==''){
		return false;
	}
	else if(mapb.value==null||mapb.value==''){
		return false;
	}
	else if(luong.value==null||luong.value==''){
		return false;
	}
	else{
		return true;
	}
	
	
}
function validatePB(){
	var Stt=document.getElementById('Stt');
	var Tenpb=document.getElementById('Tenpb');
	var mota=document.getElementById('Mota');
	if(Stt.value == null||Stt.value==''){
		return false;
	}
	else if(Tenpb.value==null||Tenpb.value==''){
		return false;
	}
	else if(mota.value==null||mota.value==''){
		return false;
	}
	else{
		return true;
	}
	
	
}
function validatengaynghi(){
	var songaynghi=document.getElementById('songaynghi');
	var lydo=document.getElementById('lydo');
	if(songaynghi.value == null||songaynghi.value==''){
		return false;
	}
	else if(lydo.value==null||lydo.value==''){
		return false;
	}
	
	else{
		return true;
	}
	
	
}
function validatesubmittask(){
	var noidungtask=document.getElementById('noidungtask');
	
	if(noidungtask.value == null||noidungtask.value==''){
		return false;
	}
	
	
	else{
		return true;
	}
	
	
}
function validatetaotask(){
	var tentask=document.getElementById('tentask');
	var nhanvienthuchien=document.getElementById('nhanvienthuchien');
	var ngayhethan=document.getElementById('ngayhethan');
	var motanhiemvu=document.getElementById('motanhiemvu');
	if(tentask.value == null||tentask.value==''){
		return false;
	}
	else if(nhanvienthuchien.value==null||nhanvienthuchien.value==''){
		return false;
	}
	else if(ngayhethan.value == null||ngayhethan.value==''){
		return false;
	}
	else if(motanhiemvu.value==null||motanhiemvu.value==''){
		return false;
	}
	
	
	else{
		return true;
	}
	
	
}
	


	


