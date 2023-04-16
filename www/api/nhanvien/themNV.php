<?php
    require_once('../../database/db.php');
    require_once('../../database/conf.php');
    if (!isset($_POST['ten']) || !isset($_POST['taikhoan']) || !isset($_POST['email']) || !isset($_POST['mapb']) || !isset($_POST['luong'])) {
        die(json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ')));
    }
    else if(kiemtra_taikhoan($_POST['taikhoan'])) {
        echo json_encode(array('code' => 0,'error' => 'Tài khoản đã tồn tại'));
    } else if(kiemtra_email($_POST['email'])){
        echo json_encode(array('code' => 0,'error' => 'Địa chỉ email đã tồn tại'));
    }
    else {
        $ten = $_POST['ten'];
        $taikhoan = $_POST['taikhoan'];
        $email = $_POST['email'];
        $mapb = $_POST['mapb'];
        $luong = $_POST['luong'];
        $matkhau = $_POST['taikhoan'];
        $chucvu = 0; // Nhân viên là 0, trưởng phòng là 1, giám đốc là 2
        $img = '../images/avatar.png';
        $ngaynghi = 12;
        $options = ['cost' => 11];
        $hash = password_hash($matkhau, PASSWORD_BCRYPT,$options);
        /* if($mapb == ''){
            echo json_encode(array('code' => 0,'error' => 'Nhân viên chưa có phòng ban !'));
            die();
        } */
        $sql = "INSERT INTO nhanvien(taikhoan,matkhau,ten, email, chucvu, mapb, img, luong, ngaynghi) VALUES  (?,?,?,?,?,?,?,?,?)";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm -> bind_param('ssssiisii',$taikhoan,$hash,$ten,$email,$chucvu,$mapb,$img,$luong,$ngaynghi);
        /* if (!$stm->execute()){
            return array('code' => 1,'error' => 'Không thể thực thi');
        } */
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Thêm nhân viên thành công'));
        }

    }

?>