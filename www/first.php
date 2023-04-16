<?php
    require_once('database/conf.php');
    session_start();
    if (!isset($_SESSION['taikhoan']) && !isset($_SESSION['manv'])) {
        header('Location: login.php');
        exit();
    }

	/* if($_SESSION['chucvu'] == 0){
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
	} */
    $nhanvien = lay1NV_manv($_SESSION['manv']);

    if(!password_verify($nhanvien['taikhoan'],$nhanvien['matkhau'])){
        header('Location: index.php');
        exit();
    }
    $error = '';
    $taikhoan = '';
    $oldpass = '';
    $newpass = '';
    $pass ='';
    $success='';
    $hashed_password =$nhanvien['matkhau'];
    if (isset($_POST['oldpass']) && isset($_POST['newpass'])&& isset($_POST['pass'])&& isset($_POST['taikhoan'])) {
        $taikhoan =$_POST['taikhoan'];
        $oldpass = $_POST['oldpass'];
        $newpass =  $_POST['newpass'];
        $pass = $_POST['pass'];
        
        if (empty($oldpass)) {
            $error = 'Vui lòng nhập mật khẩu cũ';
        }
        else if (empty($newpass) ||empty($pass) ) {
            $error = 'Vui lòng nhập mật khẩu mới';
        }
        else if (strlen($pass) < 6) {
            $error = 'Mật khẩu phải dài hơn 6 ký tự';
        }else if ($newpass != $pass) {
            $error = 'Mật khẩu nhập mới không trùng khớp';
        }else if(strcmp($taikhoan,$pass) == 0){
            $error = "Mật khẩu không mới được giống tài khoản";
        }else if(!password_verify($oldpass,$hashed_password)){
            $error = "Mật khẩu cũ sai vui lòng nhập lại";
        }
        else{
            $result =  changePass($taikhoan,$pass);
             if($result['code'] == 1){
                $success = $result['data'] .'. Vui lòng đăng xuất đăng nhập vào giao diện công việc';
                sleep(5);
                header('Location: index.php');
                exit();
            }else {
                $error = $result['data'];
            } 

            
        } 

    }
        

?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" />

</head>
<body>
    <div class="login-form">
        <form action="" method="post">
            <h3 class="text-center">Nhập mật khẩu mới</h3>   
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </span>                    
                    </div>
                    <input type="text" class="form-control" name="taikhoan" value="<?=$_SESSION['taikhoan']?>" required="required" hidden>
                    <input type="password" class="form-control" name="oldpass" placeholder="Mật khẩu cũ" >				
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>                    
                    </div>
                    <input type="password" class="form-control" name="newpass" placeholder="Mật khẩu mới">				
                </div>
            </div> 
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>                    
                    </div>
                    <input type="password" class="form-control" name="pass" placeholder="Nhập lại mật khẩu" >				
                </div>
            </div>         
            <div class="form-group">
            <?php
                if (!empty($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }else if(!empty($success)){
                    echo "<div class='alert alert-success'>$success</div>";
                }
            ?>
            </div> 
            <div class="form-group">
                <button type="submit" class="btn btn-primary login-btn btn-block">Xác Nhận</button>
                <a type="button" href="logout.php" id="a-logout" class="btn btn-primary login-btn btn-block">Đăng xuất</a>
            </div>
            
            
        </form>
        
    </div>
</body>
