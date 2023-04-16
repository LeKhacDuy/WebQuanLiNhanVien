<?php
  session_start();
  ob_start();
  require_once('../database/conf.php');
  if (!isset($_SESSION['taikhoan']) && !isset($_SESSION['manv'])) {
      header('Location: ../login.php');
      exit();
  }

  if(password_verify($_SESSION['taikhoan'],$_SESSION['matkhau'])){
    header('Location: ../first.php');
    exit();
  }
  if($_SESSION['chucvu'] == 0){
    header('Location: ../nhanvien/index.php');
        exit();
  }
  if($_SESSION['chucvu'] == 1){
    header('Location: ../truongphong/index.php');
        exit();
  } 
  include('../header.php');
  $nhanvien = lay1NV_manv($_SESSION['manv']);


  $error = '';
  $taikhoan = '';
  $oldpass = '';
  $newpass = '';
  $pass ='';
  $success='';
  $hashed_password = $nhanvien['matkhau'];
  if (isset($_POST['oldpass']) && isset($_POST['newpass'])&& isset($_POST['pass'])) {
      $taikhoan = $nhanvien['taikhoan'];
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
              $success = 'Thay đổi mật khẩu thành công';
              
          }else {
              $error = 'Thay đổi mật khẩu thất bại xin vui lòng kiểm tra thông tin nhập vào';
              
          } 

          
      } 
      unset($_POST['oldpass']);
      unset($_POST['newpass']);
      unset($_POST['pass']);

  }

  $targetDir = "../images/"; 


  $err = '';
  $suc ='';
  $allowTypes = array('jpg','png','jpeg','gif','webp');
  $fileType = '';
  if(isset($_POST['upload']) && !empty($_FILES["file"]["name"])){

  //    $fileName = basename($_FILES["file"]["name"]);
      $temp = explode(".", $_FILES["file"]["name"]);
      $fileName = round(microtime(true)) . '.' . end($temp);
      $targetFilePath =  $targetDir . $fileName;
      $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

      if(in_array($fileType, $allowTypes)){
          // Upload file to server
          if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
              // Insert image file name into database
              
              $result = uploadHinh($nhanvien['manv'],$targetFilePath);
              if($result['code'] == 1){
                  if($nhanvien['img']!='../images/avatar.png'){
                    unlink($nhanvien['img']); // xóa file cũ
                  }
                  
                  header("Location: ../index.php");
                  $suc = "Upload ảnh đại diện thành công";
                  ob_end_flush();
              }else{
                  $err = "Upload ảnh đại diện thất bại";
              } 
          }else{
              $err = "Có lỗi xảy ra trong quá trình upload ảnh";
          }
      }else{
          $err = "Chỉ cho phép upload các file ảnh có định dạnh là '.jpg', '.png', '.jpeg', '.gif', '.webp'";
         // $err= $fileType;
        }
  }else if(isset($_POST['upload']) && empty($_FILES["file"]["name"])){
     $err = "Bạn cần phải chọn ảnh để upload";
  }

?>

<body>
    <?php
        include('../navbar.php');
        
        include('slidebar.php');
    ?>
     <main class="mt-5 pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Thông tin cá nhân</div>
              <div class="card-body">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Thông tin</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Đổi mật khẩu</button>
                </li>
              </ul>
              <!-- Thông tin cá nhân -->
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                  
                  <div class="card-body media align-items-center">
                      <div class="media-body ml-4">
                      <img class="img-fluid rounded mx-auto d-block" src="<?=$nhanvien['img']?>" alt="ảnh nhân viên <?=$nhanvien['ten']?>"?>
                      </div>
                  </div>
                  <hr class="border-light m-0">
                  <div class="card-body">
                    <div class="form-group mt-3">
                        <label class="form-label fw-bolder">Mã nhân viên: <?=$nhanvien['manv']?></label>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label ">Họ và tên: <?=$nhanvien['ten']?></label>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Tên tài khoản: <?=$nhanvien['taikhoan']?></label>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Chức vụ:      </label> <?=chucVu($nhanvien['chucvu'])?>
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Phòng Ban: <?=tenPB($nhanvien['mapb'])?></label>                          
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Địa chỉ email: <?=$nhanvien['email']?></label>                          
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Lương: <?=$nhanvien['luong']?></label>                          
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Số ngày nghỉ còn lại: <?=$nhanvien['ngaynghi']?></label>                          
                    </div>
                  </div>
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="m-3">
                      <label  class="form-label">Upload ảnh</label>
                      <input class="form-control" type="file" name="file">
                    </div>
                      <?php
                          if (!empty($err)) {
                            echo "<div class='alert alert-danger m-3'>$err</div>";
                          }else if(!empty($suc)){
                            echo "<div class='alert alert-success m-3'>$suc</div>";
                          }
                          ?>
                    <div class=form-group">
                        <input type="submit" name="upload" class="btn btn-primary bd-highlight m-3 float-right" value="Lưu thay đổi">
                    </div>  
                  </form>
                </div>
                <!-- Đổi mật khẩu -->
                <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                  <form action="index.php" method="post">
                    <div class="card-body pb-2">
                      <div class="form-group mt-3">
                          <label class="form-label">Mật khẩu hiện tại</label>
                          <input type="password" name="oldpass" class="form-control">
                      </div>
                      <div class="form-group mt-3">
                          <label class="form-label">Mật khẩu mới</label>
                          <input type="password" name="newpass" class="form-control">
                      </div>
                      <div class="form-group mt-3">
                          <label class="form-label">Nhập lại mật khẩu mới</label>
                          <input type="password" name="pass" class="form-control">
                      </div>
                      <div class="form-group mt-3">
                        <?php


                          if (!empty($error)) {
                            echo "<div class='alert alert-danger '>$error</div>";
                          }else if(!empty($success)){
                            echo "<div class='alert alert-success'>$success</div>";
                          }
                          ?>
                      </div> 
                    </div>
                    <div class="form-group text-right mt-3">
                        <button type="submit" class="btn btn-primary m-3">Đổi mật khẩu</button>&nbsp;
                    </div>
                  </form>
                </div>

              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- The Modal thong tin -->

  
        



</body>

