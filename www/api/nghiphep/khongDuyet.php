<?php
    require_once('../../database/db.php');
    require_once('../../database/conf.php');

    if (!isset($_POST['manv']) || !isset($_POST['id'])  ) {
        echo json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ'));

    } else  {   

        $manv = $_POST['manv'];
        $id = $_POST['id'];
        $ngayduyet = date('Y-m-d');
        $conn = open_database();
        // thay đổi trạng thái trong task chính
        $sql = 'UPDATE nghiphep SET trangthai = 1, ngayduyet =? WHERE id = ? AND manv = ?';
        $stm = $conn->prepare($sql);
        $stm -> bind_param('sii',$ngayduyet,$id, $manv);
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không duyệt đơn thất bại'));
            die();
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Không duyệt đơn thành công'));
        }




    }


?>




