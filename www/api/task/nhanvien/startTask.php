<?php
    require_once('../../../database/db.php');
    require_once('../../../database/conf.php');

    if (!isset($_POST['ma_task']) || !isset($_POST['manv'])  ) {
        die(json_encode(array('status' => false, 'data' => 'Tham số truyền vào không hợp lệ')));
    }else {
        
        
        $ma_task = $_POST['ma_task'];
        $manv = $_POST['manv'];

        $sql = "UPDATE task SET trangthai = 1 WHERE ma_task =? AND manv = ? AND trangthai = 0 ";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm -> bind_param('ii', $ma_task, $manv);

        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể start task'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Start task thành công'));
        }

    }


?>