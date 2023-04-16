<?php
    require_once('../../../database/db.php');
    require_once('../../../database/conf.php');

    if (!isset($_POST['ma_task']) ) {
        die(json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ')));
    }else {
        
        
        $ma_task = $_POST['ma_task'];

        $sql = "UPDATE task SET trangthai = 2 WHERE ma_task =? AND trangthai = 0";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm -> bind_param('i', $ma_task);

        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể tạo task'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Hủy task thành công'));
        }

    }


?>