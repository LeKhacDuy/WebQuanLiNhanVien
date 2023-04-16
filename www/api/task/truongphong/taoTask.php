<?php
    require_once('../../../database/db.php');
    require_once('../../../database/conf.php');

    if (!isset($_POST['mapb']) || !isset($_POST['manv']) ||  !isset($_POST['ten']) 
    || !isset($_POST['deadline'])  || !isset($_POST['mota']) ) {
        die(json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ!')));
    }else {
        
        
        $ten = $_POST['ten'];
        $mapb = $_POST['mapb'];
        $manv = $_POST['manv'];
        $mota = $_POST['mota'];
        $deadline = $_POST['deadline'];
        $trangthai = 0;

        $sql = "INSERT INTO task(ten, mapb, manv, mota, deadline, trangthai)
         VALUES (?,?,?,?,?,?)";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm -> bind_param('siissi', $ten, $mapb, $manv, $mota, $deadline, $trangthai);

        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Giao task thất bại!'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Tạo task thành công!'));
        }

    }


?>