<?php
    require_once('../../database/db.php');
    require_once('../../database/conf.php');

    if (!isset($_POST['manv']) || !isset($_POST['id']) ||  !isset($_POST['songaynghi']) ) {
        echo json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ'));

    } else  {   
           
        $manv = $_POST['manv'];
        $id = $_POST['id'];
        $songaynghi = $_POST['songaynghi'];
        $ngayduyet = date('Y-m-d');
        $conn = open_database();
        $sql = 'UPDATE nghiphep SET trangthai = 2, ngayduyet=? WHERE id = ? AND manv = ?';
        $stm = $conn->prepare($sql);
        $stm -> bind_param('sii',$ngayduyet,$id, $manv);
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Duyệt đơn thất bại'));
            die();
        } 


        $sql1 = 'UPDATE nhanvien SET ngaynghi = ngaynghi - ? WHERE manv = ?';
        $stm1 = $conn->prepare($sql1);
        $stm1 -> bind_param('ii',$songaynghi, $manv);
        if (!$stm1->execute()){
            echo json_encode(array('code' => 0,'error' => 'Duyệt đơn không thành công'));
            die();
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Duyệt đơn  thành công'));
        }



    }


?>




