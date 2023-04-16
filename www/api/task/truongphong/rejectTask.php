<?php
    require_once('../../../database/db.php');
    require_once('../../../database/conf.php');

    if (!isset($_POST['ma_task']) || !isset($_POST['feedback']) || !isset($_POST['stt'])  
    || !isset($_POST['giahan'])) {
        echo json_encode(array('code' => 0, 'data' => 'Tham số truyền vào không hợp lệ'));
        exit();
    }else {

        //echo json_encode(array('status' => false, 'data' => $_FILES['filetruongphong']['name']));
        $stt = $_POST['stt'];
        $ma_task = $_POST['ma_task'];
        $feedback = $_POST['feedback'];

        $giahan = 0;
        
        if($_POST['giahan']> 0){
            $giahan = $_POST['giahan'];
        }

        $duyet = 1;
        $filetruongphong ='';

        $fileType = '';

        $targetDir = "../../../file/"; 
        $maxsize = 20*1024*1024;
        $conn = open_database();
        // trường hợp không có file đính kèm
        $allowTypes = array('pdf', 'zip', 'rar', 'docx', 'xlsx', 'pptx', 'doc', 'txt');
        if(empty($_FILES["filetruongphong"]["name"])){
            
            $sql = 'UPDATE  chitiet_task 
                    SET     filetruongphong = ?,
                            duyet = ?,
                            feedback = ?
                    WHERE ma_task = ? AND stt =? ';

            $stm = $conn->prepare($sql);
            $stm -> bind_param('sisii', $filetruongphong, $duyet, $feedback,$ma_task, $stt);
            if (!$stm->execute()){
                echo json_encode(array('code' => 0,'error' => 'Reject task không thành công if 1'));
                exit();
            } else{
               // echo json_encode(array('code' => 1, 'data' => 'Reject task thành công'));
            }
        }else {
            $temp = explode(".", $_FILES["filetruongphong"]["name"]);
            $filename = 'feedback_task_'.$ma_task.'_'.round(microtime(true)) . '.' . end($temp);
            $targetFilePath =  $targetDir . $filename; // đường dẫn để input file
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            if(!in_array($fileType, $allowTypes)){ // kiểm tra dung lượng ảnh               
                echo json_encode(array('code' => 0,'error' => "Chỉ cho phép upload các file ảnh có định dạnh là '.jpg', '.png', '.jpeg', '.gif', '.webp'" ));
                exit();
            }else if($_FILES["filetruongphong"]["size"] > $maxsize){
                echo json_encode(array('code' => 0,'error' => "Dung lượng file quá lớn ( > 20mb )" ));
                exit();
            }else{    
               if(move_uploaded_file($_FILES["filetruongphong"]["tmp_name"], $targetFilePath)){
                    
                    
                    $sql = 'UPDATE  chitiet_task 
                            SET     filetruongphong = ?,
                                    duyet = ?,
                                    feedback = ?
                            WHERE ma_task = ? AND stt =? ';
                    $stm = $conn->prepare($sql);
                    $stm -> bind_param('sisii', $filename, $duyet, $feedback,$ma_task, $stt);
                    if (!$stm->execute()){
                        echo json_encode(array('code' => 0,'error' => 'Reject task không thành công if2'));
                        exit();
                    } else{
                    
                    }
                    
                }else{
                    echo json_encode(array('code' => 0,'error' => "Có lỗi xảy ra trong quá trình upload file!" ));

                    exit();
                }
                // $err= $fileType;
            }
        }

        // thay đổi trạng thái trong task chính
        $sql = 'UPDATE task SET 
                    trangthai = 4,
                     deadline = deadline + INTERVAL ? DAY
                WHERE ma_task = ?';
        $stm = $conn->prepare($sql);
        $stm -> bind_param('ii',$giahan, $ma_task);
        if (!$stm->execute()){
            echo json_encode(array('code' => 0,'error' => 'Reject task không thành công task'));
            exit();
        } else{
            echo json_encode(array('code' => 1, 'data' => 'Reject task thành công'));
        }




    }


?>




