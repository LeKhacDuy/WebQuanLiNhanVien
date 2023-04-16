<?php
    header('Access-Control-Allow-Origin: *');
    header("Content-type: application/json; charset = utf-8");
    require_once('../../database/db.php');
    require_once('../../database/conf.php');
    
    if (!isset($_POST['mapb'])) {
        die(json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ !'))); 
    } else if (kiemtraNV_mapb($_POST['mapb'])){
        echo json_encode(array('code' => 0,'error' => 'Không thể xóa phòng ban có nhân viên !'));
    }
    else {
        $mapb = $_POST['mapb'];

        $sql = "DELETE FROM phongban WHERE mapb =?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm -> bind_param('i', $mapb);
        /* if (!$stm->execute()){
            return array('code' => 1,'error' => 'Không thể thực thi');
        } */
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Xóa phòng ban thất bại'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Xóa phòng ban thành công'));
        }

    }

?>