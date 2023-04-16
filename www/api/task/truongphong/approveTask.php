<?php
    require_once('../../../database/db.php');
    require_once('../../../database/conf.php');

    if ( !isset($_POST['ma_task']) || !isset($_POST['danhgia']) || !isset($_POST['stt']) ) {
        echo json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ'));
    }else {

        //echo json_encode(array('status' => false, 'data' => $_FILES['filetruongphong']['name']));
        $stt = $_POST['stt'];
        $ma_task = $_POST['ma_task'];
        $danhgia = $_POST['danhgia'];


        $duyet = 2;




        $conn = open_database();
         
        $sql = 'UPDATE  chitiet_task 
                SET     
                        duyet = ?,
                        danhgia = ?
                WHERE ma_task = ? AND stt =? ';

        $stm = $conn->prepare($sql);
        $stm -> bind_param('iiii',  $duyet, $danhgia,$ma_task, $stt);
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Approve task không thành công '));
            die();
        } 
        
        // thay đổi trạng thái trong task chính
        $sql2 = 'UPDATE task SET 
                    trangthai = 5
                WHERE ma_task = ?';
        $stm2 = $conn->prepare($sql2);
        $stm2 -> bind_param('i',$ma_task);
        if (!$stm2->execute()){
            echo json_encode(array('code' => 0,'error' => 'Approve task không thành công task 1'));

        } else{
            echo json_encode(array('code' => 1, 'data' => 'Approve task thành công'));
        }




    }


?>




