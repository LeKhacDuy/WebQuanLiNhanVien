<?php
    require_once('../../database/db.php');
    require_once('../../database/conf.php');

    if (!isset($_POST['manv']) || !isset($_POST['mota']) || !isset($_POST['songaynghi'])  ) {
        echo json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ'));

    }else if(!ktSoNgayNghi($_POST['manv'],$_POST['songaynghi']) || ($_POST['songaynghi'] <= 0) ) {
        echo json_encode(array('code' => 0, 'error' => 'Số ngày nghỉ không hợp lệ'));
    } else  {   
           
        $manv = $_POST['manv'];
        $mota = $_POST['mota'];
        $ngaygui = date("Y-m-d");
        $trangthai = 0;
        $file ='';
        $songaynghi = $_POST['songaynghi'];
        if($songaynghi <= 0){
            echo json_encode(array('code' => 0, 'error' => 'Số ngày nghỉ không hợp lệ'));
            die();
        }
        $fileType = '';

        $targetDir = "../../file/"; 
        $maxsize = 20*1024*1024;


        $conn = open_database();
        // trường hợp không có file đính kèm
        $allowTypes = array('pdf', 'zip', 'rar', 'docx', 'xlsx', 'pptx', 'doc', 'txt');
        if(empty($_FILES["file"]["name"])){
            
            $sql = 'INSERT INTO nghiphep(manv,songaynghi,mota, ngaygui, `file`, trangthai)
            VALUES (?,?,?,?,?,?)';
            $stm = $conn->prepare($sql);
            $stm -> bind_param('iisssi', $manv,$songaynghi, $mota, $ngaygui, $file, $trangthai);
            if (!$stm->execute()){
                echo json_encode(array('code' => 0,'error' => 'Nộp đơn không thành công'));
                die();
            }else {
                echo json_encode(array('code' => 1, 'data' => 'Nộp đơn  thành công. Đơn của bạn đang chờ duyệt.'));
            }
        }else {
            $temp = explode(".", $_FILES["file"]["name"]);
            $fileName = 'nghi_phep_nv_'.$manv.round(microtime(true)) . '.' . end($temp);
            $targetFilePath =  $targetDir . $fileName; // đường dẫn để input file
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(!in_array($fileType, $allowTypes)){ // kiểm tra dung lượng ảnh               
                echo json_encode(array('code' => 0,'error' => "Chỉ cho phép upload các file có định dạnh là .txt, .pdf, .zip, .rar, .docx, .xlsx, .pptx, .doc" ));
                die();
            }else if($_FILES["file"]["size"] > $maxsize){
                echo json_encode(array('code' => 0,'error' => "Dung lượng file quá lớn ( > 20mb )" ));
                die();
            }else{    
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                    
                    
                    $sql = 'INSERT INTO nghiphep(manv,songaynghi,mota, ngaygui, `file`, trangthai)
                            VALUES (?,?,?,?,?,?)';
                    $stm = $conn->prepare($sql);
                    $stm -> bind_param('iisssi', $manv,$songaynghi, $mota, $ngaygui, $fileName, $trangthai);
                    if (!$stm->execute()){
                        echo json_encode(array('code' => 0,'error' => 'Nộp đơn không thành công'));
                        die();
                    }else {
                        echo json_encode(array('code' => 1, 'data' => 'Nộp đơn  thành công. Đơn của bạn đang chờ duyệt.'));
                    }
                }else{
                    echo json_encode(array('code' => 0,'error' => "Có lỗi xảy ra trong quá trình upload file!" ));
                    die();
                }
                // $err= $fileType;
            }
        }

        // thay đổi trạng thái trong task chính
        /* $sql = 'UPDATE nhanvien SET ngaynghi = ngaynghi - ? WHERE manv = ?';
        $stm = $conn->prepare($sql);
        $stm -> bind_param('ii',$songaynghi, $manv);
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Nộp đơn không thành công'));
            die();
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Nộp đơn  thành công'));
        } */




    }


?>




