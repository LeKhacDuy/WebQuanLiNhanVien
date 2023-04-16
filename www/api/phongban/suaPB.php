<?php
    header('Access-Control-Allow-Origin: *');
    header("Content-type: application/json; charset = utf-8");
    require_once('../../database/db.php');
    require_once('../../database/conf.php');
    
    if (!isset($_POST['mapb']) || !isset($_POST['stt'])|| !isset($_POST['truongphong']) 
    || !isset($_POST['tenpb']) || !isset($_POST['mota'])) {
        die(json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ'))); 
    } else if (!kiemtraNV_manv_mapb($_POST['truongphong'],$_POST['mapb']) ){
        echo json_encode(array('code' => 0,'error' => 'Trưởng phòng không hợp lệ'));
    }
    else {
        $mapb = $_POST['mapb'];
        $stt = $_POST['stt'];
        $tenpb = $_POST['tenpb'];
        $truongphong = $_POST['truongphong'];
        $mota = $_POST['mota'];

        // thông tin dữ liệu phòng ban cũ ( trước khi thay đổi)
        $phongbanCu = lay1PB_mapb($mapb);

        // toàn bộ thông tin của trưởng phòng cũ
        $truongphongCu = lay1NV_manv($phongbanCu['truongphong']);


        $conn = open_database();
             // trưởng phòng cũ khác trưởng phòng mới
            if($truongphongCu['manv']!= $truongphong){
                if($truongphongCu['ngaynghi'] >= 3){
                    $sql_1 = "UPDATE nhanvien SET ngaynghi = ngaynghi - 3, chucvu = 0 WHERE manv = ? ";

                    $stm_1 = $conn->prepare($sql_1);
                    $stm_1 -> bind_param('i',$truongphongCu['manv']);
             
                    if (!$stm_1->execute()){
                        echo json_encode(array('code' => 0,'error' => 'Không thể thực thi sql 1'));
                        die();
                    } 
             
                }else {
                    $sql_1 = "UPDATE nhanvien SET chucvu = 0 WHERE manv = ? ";

                    $stm_1 = $conn->prepare($sql_1);
                    $stm_1 -> bind_param('i',$truongphongCu['manv']);
             
                    if (!$stm_1->execute()){
                        echo json_encode(array('code' => 0,'error' => 'Không thể thực thi sql 1'));
                        die();
                    } 
                }

                $sql_2 = "UPDATE nhanvien SET ngaynghi = ngaynghi + 3, chucvu = 1, activated = 1 WHERE manv = ? ";
            
                $stm_2 = $conn->prepare($sql_2);
                $stm_2 -> bind_param('i',$truongphong);
            
                if (!$stm_2->execute()){
                    echo json_encode(array('code' => 0,'error' => 'Không thể thực thi sql 2'));
                    die();
                } 
                

            }
            
       /*  } */
        
       



        $sql = "UPDATE  phongban
            SET stt = ? ,
                tenpb = ?,
                truongphong =? ,
                mota = ?
            WHERE mapb = ?";
        
        
        $stm = $conn->prepare($sql);
        $stm -> bind_param('isisi',$stt, $tenpb,$truongphong, $mota, $mapb);

        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Không thể thực thi'));
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Cập nhập thông tin phòng ban thành công'));
        }
        
    }

?>