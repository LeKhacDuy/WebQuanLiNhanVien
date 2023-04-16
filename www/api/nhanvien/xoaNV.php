<?php

    require_once('../../database/db.php');
    
    if (!isset($_POST['manv'])) {
        die(json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ')));
    } /* else if (kiemtraNV_mapb($_POST['mapb'] > 0)){
        echo json_encode(array('code' => 0,'data' => 'Không thể xóa phòng ban có nhân viên'));
    } */
    else {
        $manv = $_POST['manv'];

        $conn = open_database();
        // cập nhập trưởng phòng
        $sql1 = "UPDATE phongban SET truongphong = 0 WHERE truongphong = ?";
        $stm1 = $conn->prepare($sql1);
        $stm1 -> bind_param('i', $manv);

        if ($stm1->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        }
        // xóa lịch sử nghỉ phép
        $sql2 = "DELETE FROM nghiphep WHERE manv =?";
        
        $stm2 = $conn->prepare($sql2);
        $stm2 -> bind_param('i', $manv);

        if (!$stm2->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        }
        // xóa lịch sử task
        $sql3 = "DELETE FROM task WHERE manv =?";
        
        $stm3 = $conn->prepare($sql3);
        $stm3-> bind_param('i', $manv);

        if (!$stm3->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        }

        // xóa lịch sử chi tiết task
         $sql4 = "DELETE FROM  chitiet_task 
         WHERE ma_task in (
             SELECT ma_task FROM task WHERE manv = ?
              )";
        
        $stm4 = $conn->prepare($sql4);
        $stm4-> bind_param('i', $manv);

        if (!$stm4->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        } 
        // xóa nhân viên
        $sql = "DELETE FROM nhanvien WHERE manv =?";
        
        $stm = $conn->prepare($sql);
        $stm -> bind_param('i', $manv);
        /* if (!$stm->execute()){
            return array('code' => 1,'error' => 'Không thể thực thi');
        } */

        

        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Xóa nhân viên thành công'));
        }



    }

?>