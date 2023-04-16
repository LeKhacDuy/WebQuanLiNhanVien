<?php
    header('Access-Control-Allow-Origin: *');
    header("Content-type: application/json; charset = utf-8");
    require_once('../../database/db.php');
    
    if (!isset($_POST['stt']) || !isset($_POST['tenpb']) || !isset($_POST['mota'])) {
         die(json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ'))); 
    }else {
        $stt = $_POST['stt'];
        $tenpb = $_POST['tenpb'];
        $mota = $_POST['mota'];
        $truongphong = 0; // mặc định khi tạo phòng ban trưởng phòng là không có

        $sql = "INSERT INTO phongban(stt,tenpb,mota, truongphong) VALUES  (?,?,?,?)";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm -> bind_param('issi',$stt, $tenpb, $mota, $truongphong);
        /* if (!$stm->execute()){
            return array('code' => 1,'error' => 'Không thể thực thi');
        } */
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Thêm phòng ban thành công'));
        }
        mysqli_close($conn);
    }

?>