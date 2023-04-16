<?php
    header('Access-Control-Allow-Origin: *');
    header("Content-type: application/json; charset = utf-8");
    require_once('../../database/db.php');
    
    if (!isset($_POST['manv'])|| !isset($_POST['taikhoan'])) {
        die(json_encode(array('code' => 0, 'error' => 'Dữ liệu không hợp lệ'))); 
    } /* else if (kiemtraNV_mapb($_POST['mapb'] > 0)){
        echo json_encode(array('code' => 0,'data' => 'Không thể xóa phòng ban có nhân viên'));
    } */
    else {
        $manv = $_POST['manv'];
        $taikhoan = $_POST['taikhoan'];
        $conn = open_database();

        $options = ['cost' => 11];
        $hash = password_hash($taikhoan, PASSWORD_BCRYPT,$options);

        $sql = "UPDATE  nhanvien SET matkhau=? WHERE manv =?";
        
        $stm = $conn->prepare($sql);
        $stm -> bind_param('si',$hash, $manv);
        /* if (!$stm->execute()){
            return array('code' => 1,'error' => 'Không thể thực thi');
        } */


        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Reset mật khẩu nhân viên không thành côngi'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Reset mật khẩu nhân viên thành công'));
        }



    }

?>