<?php
    require_once('database/conf.php');
    session_start();
    if (isset($_SESSION['taikhoan'])) {
        header('Location: index.php');
        exit();
    }

    $error = '';

    $user = '';
    $pass = '';

    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $result =  login($user,$pass);
        if (empty($user)) {
            $error = 'Vui lòng nhập tên tài khoản';
        }
        else if (empty($pass)) {
            $error = 'Vui lòng nhập mật khẩu';
        }
        /* else if (strlen($pass) < 6) {
            $error = 'Mật khẩu phải dài hơn 6 ký tự';
        } */
        else if($result['code'] == 0){
                $data = $result['data'];
                $_SESSION['manv'] = $data['manv'];
                $_SESSION['ten'] = $data['ten'];
                $_SESSION['taikhoan'] = $user;
                $_SESSION['chucvu'] = $data['chucvu'];
                $_SESSION['matkhau'] = $data['matkhau'];
                header('Location: index.php');
                exit();
        }
        else {
            $error = $result['error'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
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
        <h2 class="text-center">Đăng nhập</h2>   
        <div class="form-group">
        	<div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <span class="fa fa-user"></span>
                    </span>                    
                </div>
                <input type="text" class="form-control" name="user" placeholder="Tài khoản" required="required">				
            </div>
        </div>
		<div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>                    
                </div>
                <input type="password" class="form-control" name="pass" placeholder="Mật khẩu" required="required">				
            </div>
        </div>        
        <div class="form-group">
            <?php
                if (!empty($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            ?>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary login-btn btn-block">Đăng nhập</button>
        </div>
        <!-- <div class="clearfix">
            <label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
           
        </div> -->
		
    </form>
    
</div>
</body>
</html>