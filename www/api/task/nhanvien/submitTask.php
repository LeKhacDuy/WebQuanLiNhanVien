<?php
    require_once('../../../database/db.php');
    require_once('../../../database/conf.php');

    if (!isset($_POST['ma_task']) || !isset($_POST['mota'])   ) {
        echo json_encode(array('code' => 0, 'error' => 'Tham số truyền vào không hợp lệ'));

    }else {
        
        
        $ma_task = $_POST['ma_task'];
        $mota = $_POST['mota'];
        $ngaynop = date("Y-m-d");
        $duyet = 0;
        $filenhanvien ='';

        $fileType = '';

        $targetDir = "../../../file/"; 
        $maxsize = 20*1024*1024;

        $stt = ktSL($ma_task) + 1;

        $conn = open_database();
        // trường hợp không có file đính kèm
        $allowTypes = array('pdf', 'zip', 'rar', 'docx', 'xlsx', 'pptx', 'doc', 'txt');
        if(empty($_FILES["filenhanvien"]["name"])){
            
            $sql = 'INSERT INTO chitiet_task(stt,ma_task,mota, ngaynop, filenhanvien, duyet)
            VALUES (?,?,?,?,?,?)';
            $stm = $conn->prepare($sql);
            $stm -> bind_param('iisssi', $stt,$ma_task, $mota, $ngaynop, $filenhanvien, $duyet);
            if (!$stm->execute()){
                echo json_encode(array('code' => 0,'error' => 'Submit task không thành công'));
                die();
            } else{
              //  echo json_encode(array('code' => 1, 'data' => 'Submit task thành công'));
            }
        }else {
            $temp = explode(".", $_FILES["filenhanvien"]["name"]);
            $fileName = 'task_'.$ma_task.'_nv_'.round(microtime(true)) . '.' . end($temp);
            $targetFilePath =  $targetDir . $fileName; // đường dẫn để input file
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(!in_array($fileType, $allowTypes)){ // kiểm tra dung lượng ảnh               
                echo json_encode(array('code' => 0,'error' => "Chỉ cho phép upload các file có định dạnh là .txt, .pdf, .zip, .rar, .docx, .xlsx, .pptx, .doc" ));
                die();
            }else if($_FILES["filenhanvien"]["size"] > $maxsize){
                echo json_encode(array('code' => 0,'error' => "Dung lượng file quá lớn ( > 20mb )" ));
                die();
            }else{    
                if(move_uploaded_file($_FILES["filenhanvien"]["tmp_name"], $targetFilePath)){
                    
                    
                    $sql = 'INSERT INTO chitiet_task(stt,ma_task,mota, ngaynop, filenhanvien, duyet)
                    VALUES (?,?,?,?,?,?)';
                    $stm = $conn->prepare($sql);
                    $stm -> bind_param('iisssi',$stt, $ma_task, $mota, $ngaynop, $fileName, $duyet);
                    if (!$stm->execute()){
                        echo json_encode(array('code' => 0,'error' => 'Submit task không thành công'));
                        die();
                    } else{
                       // echo json_encode(array('code' => 1, 'data' => 'submit task thành công'));
                    }
                }else{
                    echo json_encode(array('code' => 0,'error' => "Có lỗi xảy ra trong quá trình upload file!" ));
                    die();
                }
                // $err= $fileType;
            }
        }

        // thay đổi trạng thái trong task chính
        $sql = 'UPDATE task SET trangthai = 3 WHERE ma_task = ?';
        $stm = $conn->prepare($sql);
        $stm -> bind_param('i', $ma_task);
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Submit task không thành công'));
            die();
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Submit task thành công'));
        }




    }


?>




