<?php
	
    session_start();
    if (!isset($_SESSION['manv'])) {
        header('Location: login.php');
        exit();
    }
	require_once('database/conf.php');
	$nhanvien = lay1NV_manv($_SESSION['manv']);
	if(password_verify($nhanvien['taikhoan'],$nhanvien['matkhau'])){
        header('Location: first.php');
		exit();
    }
	/* if(password_verify($_SESSION['taikhoan'],$_SESSION['matkhau'])){
		header('Location: first.php');
		exit();
	} */
	if($_SESSION['chucvu'] == 0){
		header('Location: nhanvien/index.php');
        exit();
	}
	if($_SESSION['chucvu'] == 1){
		header('Location: truongphong/index.php');
        exit();
	}
	if($_SESSION['chucvu'] == 2){
		header('Location: giamdoc/index.php');
        exit();
	} 
	include('header.php');
?>

<body>
	<?php
	include('navbar.php');
	//echo $_SESSION['matkhau'];
	?>

</body>



