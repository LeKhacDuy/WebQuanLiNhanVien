<?php
    require_once('db.php');


    function login($user,$pass){
        $sql = "select * from nhanvien where taikhoan = ?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm -> bind_param('s',$user);
        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }
        $result = $stm->get_result();
        if($result->num_rows==0){
            return array('code' => 1,'error' => 'Tài khoản không tồn tại');
        }
        $data = $result->fetch_assoc();

        $hashed_password = $data['matkhau'];
        if(!password_verify($pass,$hashed_password)){
            return array('code' => 2,'error' => 'Mật khẩu không chính xác');
        } 
        else{
            return array('code' => 0,'error' => '','data' => $data);
        }
    }

    function changePass($taikhoan,$matkhau){
         if(strcmp($taikhoan,$matkhau) == 0){
            return array('code' => 0,'data' => 'Tài khoản và mật khẩu mới không được giống nhau');
        }
        $sql = "UPDATE nhanvien SET matkhau=? WHERE taikhoan=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        
        $options = ['cost' => 11];
        $hash = password_hash($matkhau, PASSWORD_BCRYPT,$options);

        $stm -> bind_param('ss',$hash,$taikhoan);
        if (!$stm->execute()){
            return array('code' => 0,'data' => 'Không thể thực thi');
        } else{
            return array('code' => 1, 'data' => 'Đổi mật khẩu mới thành công');
        } 
    
    }

    function test(){
        $options = ['cost' => 11];
        $pass = '123456';
        $hash = password_hash($pass, PASSWORD_BCRYPT,$options);
        $hash1 = password_hash($pass, PASSWORD_BCRYPT, $options );

        echo $hash;
        echo '<br>';
        print_r($hash1);

        if (password_verify($pass, $hash1) && password_verify($pass, $hash)) {
            echo ' Mật khẩu đúng';
        } else {
            echo 'sai mật khẩu.';
        }
    }


    // Nhân viên --------------------------------------------------------------------
    function layNV(){
        $conn = open_database();
        $sql = "SELECT * FROM nhanvien ";
        $stm = $conn->prepare($sql);


        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }

        return json_encode(array('code' => 0, 'data' => $data));
    }
    
    function layNV_manv($id) {
        $conn = open_database();
        $sql = "SELECT * FROM nhanvien WHERE manv = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);


        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }

        return json_encode(array('code' => 0, 'data' => $data));
    }
    function layNV_mapb($id) {
        $conn = open_database();
        $sql = "SELECT * FROM nhanvien WHERE mapb = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);

        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }

        return json_encode(array('code' => 0, 'data' => $data));
    }

    function layNV_manv_mapb($manv, $mapb) {
        $conn = open_database();
        $sql = "SELECT * FROM nhanvien WHERE manv = ? and mapb = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("ii", $manv, $mapb);

        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }

        return json_encode(array('code' => 0, 'data' => $data));
    }

    function lay1NV_manv($id){
        $conn = open_database();
        $sql = 'SELECT * FROM nhanvien WHERE manv = ?';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);
        if(!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not excute');
        }
        $result = $stm -> get_result();
        /* if($result->num_rows == 0){
            session_unset();
            session_destroy();
            header('Location: ../login.php');
            exit();
        } */
        $data = $result->fetch_assoc();
        return $data;
    }
    // Phòng ban --------------------------------------------------------------------
    function layPB(){
        $conn = open_database();
        $sql = "SELECT * FROM phongban ";
        $stm = $conn->prepare($sql);


        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }

        return json_encode(array('code' => 0, 'data' => $data));
    }

    function layPB_mapb($id) {
        $conn = open_database();
        $sql = "SELECT * FROM phongban WHERE mapb = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);


        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }
        
        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }

        return json_encode(array('code' => 0, 'data' => $data));
    }



    function chucVu($chucVu){
        if($chucVu == 0 ){
       //     return 'Nhân viên';
            return '<button  type="button" class="btn-chucvu btn btn-info w-100 ">Nhân viên</button>';
        }else if($chucVu == 1){
         //   return 'Trưởng phòng';
            return '<button type="button" " class="btn-chucvu btn btn-warning  w-100 ">Trưởng phòng</button>';
        }else if($chucVu == 2){
        //    return 'Giám đốc';
            return '<button type="button"  class="btn-chucvu btn btn-success  w-100 ">Giám đốc</button>';
        }
    }

    

    function truongPhong($id){
        if($id == 0){
            return 'Chưa có';
        }

        $conn = open_database();
        $sql = 'SELECT ten FROM nhanvien WHERE manv = ?';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);
        if(!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not excute');
        }
        $result = $stm -> get_result();
        $data = $result->fetch_assoc();
        return $data['ten'];

    }

    function tenPB($id){
        $conn = open_database();
        $sql = 'SELECT tenpb FROM phongban WHERE mapb = ?';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);
        if(!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not excute');
        }
        $result = $stm -> get_result();
        $data = $result->fetch_assoc();
        return $data['tenpb'];
    }

    function lay1PB_mapb($id){
        $conn = open_database();
        $sql = 'SELECT * FROM phongban WHERE mapb = ?';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);
        if(!$stm->execute()){
            return array('code' => 1, 'error' => 'Can not excute');
        }
        $result = $stm -> get_result();
        $data = $result->fetch_assoc();
        return $data;
    }

    // so luong nhan vien
    
    function soLuongNV($mapb){
        $conn = open_database();
        $sql ="SELECT * FROM nhanvien WHERE mapb = ? ";
        $stm = $conn->prepare($sql);
        $stm->bind_param('i', $mapb);

        if(!$stm-> execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }
        $result = $stm->get_result();

        return $result->num_rows;
    }
    // Hàm kiểm tra -------------------------------------
    function kiemtraNV_mapb($mapb){
        $conn = open_database();
        $sql ="SELECT manv FROM nhanvien WHERE mapb = ? ";
        $stm = $conn->prepare($sql);
        $stm->bind_param('i', $mapb);

        if(!$stm-> execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }
        $result = $stm->get_result();

        if($result->num_rows > 0){
            return true;
        }else {
            return false;
        }
        
    }

    function kiemtraNV_manv_mapb($manv, $mapb) {
        if($manv == 0){
            return true;
        }
        $conn = open_database();
        $sql = "SELECT * FROM nhanvien WHERE manv = ? and mapb = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("ii", $manv, $mapb);

        if($mapb == 0){
            return true;
        }
        if (!$stm->execute()){
            return array('code' => 1,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();
        
        if($result->num_rows > 0){
            return true;
        }else {
            return false;
        }
    }

    
    
    function kiemtra_email($email){
        $sql = 'select manv from nhanvien where email = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if(!$stm-> execute()){
            die('Query error: '.$stm->error);
        }
        $result = $stm->get_result();

        if($result->num_rows > 0){
            return true;
        }else {
            return false;
        }
    }

    function kiemtra_taikhoan($taikhoan){
        $sql = 'select manv from nhanvien where taikhoan = ?';
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $taikhoan);
        if(!$stm-> execute()){
            die('Query error: '.$stm->error);
        }
        $result = $stm->get_result();

        if($result->num_rows > 0){
            return true;
        }else {
            return false;
        }
    }

    function uploadHinh($id,$img){
        $sql = 'UPDATE nhanvien SET img = ? WHERE manv = ? ';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('si',$img, $id);

        if (!$stm->execute()){
            return array('code' => 0,'data' => 'Upload ảnh đại diện thất bại');
        } else{
            return array('code' => 1, 'data' => 'Upload ảnh đại diện thành công');
        } 
    }
    //task all
    function trangThaiTask($trangthai){
        if($trangthai == 0){ // new
            return '<button  type="button" class="btn-trangthai btn btn-info w-100 fst-normal text-light">New</button>';
        } else if ($trangthai == 1 ){ // in progress
            return '<button  type="button" class="btn-trangthai btn btn-success fst-normal w-100 ">In progress</button>';
        } else if ($trangthai == 2){ // Canceled
            return '<button  type="button" class="btn-trangthai btn btn-danger ffst-normal w-100 ">Canceled</button>';
        } else if ($trangthai == 3){ // Waiting
            return '<button  type="button" class="btn-trangthai btn btn-warning fst-normal w-100 ">Waiting</button>';
        } else if ($trangthai == 4){ // Rejected
            return '<button  type="button" class="btn-trangthai btn btn-secondary fst-normal w-100 ">Rejected</button>';
        } else if ($trangthai == 5){ // Completed
            return '<button  type="button" class="btn-trangthai btn btn-primary fst-normal w-100 ">Completed</button>';
        }
    }
    // task truong phong
    // task
    function layTask_mapb( $mapb) {
        $conn = open_database();
        $sql = "SELECT * FROM task WHERE  mapb = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $mapb);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }
        
        return json_encode(array('code' => 1, 'data' => $data));
    }

    function lay1Task_ma_task($id){
        $conn = open_database();
        $sql = 'SELECT * FROM task WHERE ma_task = ?';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $id);
        if(!$stm->execute()){
            return array('code' => 0, 'error' => 'Can not excute');
        }
        $result = $stm -> get_result();
        $data = $result->fetch_assoc();
        return $data;
    }
    // chi tiết task
    function layChiTietTask_ma_task($ma_task){
        $conn = open_database();
        $sql = "SELECT * FROM chitiet_task WHERE  ma_task = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $ma_task);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }
        
        return json_encode(array('code' => 1, 'data' => $data));
    }

    // kiểm tra
    function kiemTraChiTietTask($id, $mapb){
        $conn = open_database();
        $sql = 'SELECT * FROM task WHERE ma_task = ? AND mapb = ? ';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("ii", $id, $mapb);
        if(!$stm->execute()){
            return array('code' => 0, 'error' => 'Can not excute');
        }
        $result = $stm->get_result();

        if($result->num_rows > 0){
            return true; // đúng
        }else {
            return false; // sai
        }
    }
    // task nhan vien
    //task
    function layTask_manv( $manv) {
        $conn = open_database();
        $sql = "SELECT * FROM task WHERE  manv = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $manv);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }
        
        return json_encode(array('code' => 1, 'data' => $data));
    }

    // chi tiết task
    // kiểm tra 
    function kiemTraChiTietTask_nv($id, $manv){
        $conn = open_database();
        $sql = 'SELECT * FROM task WHERE ma_task = ? AND manv = ? AND trangthai != 2';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("ii", $id, $manv);
        if(!$stm->execute()){
            return array('code' => 0, 'error' => 'Can not excute');
        }
        $result = $stm->get_result();

        if($result->num_rows > 0){
            return true; // đúng
        }else {
            return false; // sai
        }
    }
    
    // trạng thái duyệt

    function trangThaiDuyet($trangthai){
        if($trangthai == 0){
            return  '<button  type="button" class="btn-duyet btn btn-warning  fst-normal text-light">Đang chờ duyệt</button>';
        } else if($trangthai == 1){
            return  '<button  type="button" class="btn-duyet btn btn-danger  fst-normal text-light">Không được duyệt</button>';
        } else if($trangthai == 2){
            return  '<button  type="button" class="btn-duyet btn btn-success  fst-normal text-light">Được duyệt</button>';
        } 
    }

    function trangThaiDuyetText($trangthai){
        if($trangthai == 0){
            return  'Đang chờ duyệt';
        } else if($trangthai == 1){
            return  'Không được duyệt';
        } else if($trangthai == 2){
            return  'Được duyệt';
        } 
    }

    // dowloand file

    function download($file){
        if($file == ''){
            return 'Không có tệp đính kèm';
        }else {
          //  $filename = explode('../../../file/', $file);
            $dir = '../../file/';
            $filepath = $dir.$file;
           // return $filename[1];
            return "<a href='$filepath' download='$file' >$file</a>";
        }
    }

    // Kiểm tra nút submit
    function ktSubmit($ma_task){
        $conn = open_database();
        $sql = 'SELECT * FROM chitiet_task WHERE ma_task = ? AND duyet != 1';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $ma_task);

        if(!$stm->execute()){
            return array('code' => 0, 'error' => 'Can not excute');
        }
        $result = $stm->get_result();

        if($result->num_rows > 0){
            return true; // đúng -> đang có task chờ duyệt hoặc đã hoàn thành
        }else {
            return false; // sai -> không có task nào trong tráng thái chờ duyệt hoặc đã hoàn thành
        }
    }

    // Kiểm tra tg nộp deadline

    function ktDeadline($ngaynop, $deadline){
        if($ngaynop > $deadline){
            return 'Quá hạn nộp (Trễ deadline)';

        }else {
            return 'Nộp đúng hạn';
        }
    }

    function ktDanhGia($ngaynop, $deadline){
        if($ngaynop > $deadline){
            return false;

        }else {
            return true;
        }
    }
    // kiểm tra số lượng chi tiết task của 1 task
    function ktSL($ma_task){
        $conn = open_database();
        $sql = 'SELECT * FROM chitiet_task WHERE ma_task = ? ';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $ma_task);

        if(!$stm->execute()){
            return array('code' => 0, 'error' => 'Can not excute');
        }
        $result = $stm->get_result();


        return $result->num_rows;
    }


    // nghỉ phép
    // giám đốc
    function layNghiPhep_truongphong(){
        $conn = open_database();
        $sql = "SELECT * FROM nghiphep, nhanvien 
        WHERE nghiphep.manv = nhanvien.manv AND nhanvien.chucvu = 1
        ORDER BY ngaygui DESC";
        $stm = $conn->prepare($sql);



        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }
        
        return json_encode(array('code' => 1, 'data' => $data));
    }


    // trưởng phòng
    function layNghiPhep_mapb($mapb){
        $conn = open_database();
        $sql = "SELECT * FROM nghiphep, nhanvien 
        WHERE nghiphep.manv = nhanvien.manv AND nhanvien.mapb = ?
        ORDER BY ngaygui DESC";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $mapb);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }
        
        return json_encode(array('code' => 1, 'data' => $data));
    }



    // nhân viên
    function layNghiPhep_manv( $manv) {
        $conn = open_database();
        $sql = "SELECT * FROM nghiphep WHERE  manv = ?";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $manv);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        $data = array();

        while($row = $result -> fetch_assoc() ){
            $data[] = $row;
        }
        
        return json_encode(array('code' => 1, 'data' => $data));
    }

    // ngày duyệt
    function ngayDuyet($ngayduyet){
        if($ngayduyet == null){
            return 'Đang chờ duyệt';
        }else{
            return date("d-m-Y", strtotime($ngayduyet)) ;
        }
    }

    // kiểm tra số ngày nghỉ
    function ktSoNgayNghi($manv, $songaynghi){
        $conn = open_database();
        $sql = 'SELECT * FROM nhanvien WHERE manv = ?';
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i", $manv);
        if(!$stm->execute()){
            return array('code' => 0, 'error' => 'Can not excute');
        }
        $result = $stm -> get_result();
        $data = $result->fetch_assoc();
        if($data['ngaynghi'] <  $songaynghi){
            return false;
        }else {
            return true;
        }

    }
    // Lấy ngày duyệt cuối cùng của nhân viên
    function ngayDuyetCuoi($manv){
        $conn = open_database();
        $sql = "SELECT *
            FROM nghiphep
            WHERE manv = ?
            ORDER BY ngayduyet DESC
            LIMIT 1";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $manv);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();
        $data = $result->fetch_assoc();
        
        return $data['ngayduyet'];
    }

    // Kiểm tra đơn đang duyệt không
    // Lấy ngày duyệt cuối cùng của nhân viên
    function ktDangDuyet($manv){
        $conn = open_database();
        $sql = "SELECT *
            FROM nghiphep
            WHERE manv = ? AND trangthai = 0";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $manv);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        
        if($result->num_rows > 0){
            return true; 
        }else {
            return false; 
        }
    }
    // Kiểm tra lan nop đơn
    function lanNop($manv){
        $conn = open_database();
        $sql = "SELECT *
            FROM nghiphep
            WHERE manv = ? ";
        $stm = $conn->prepare($sql);
        $stm ->bind_param("i",  $manv);


        if (!$stm->execute()){
            return array('code' => 0,'error' => 'Can not execute');
        }

        $result = $stm -> get_result();

        
        if($result->num_rows > 0){
            return true; 
        }else {
            return false; 
        }
    }
    // 
    // Kiểm tra nút nộp đơn
    function ktBtnNopDon($manv){
        /* if(lay1NV_manv($manv)['ngaynghi'] == 0){
            return '';
        } */
        if(!lanNop($manv)){
            return '<span class="btn  p-2 btn-primary btn-chucnang w-100  bd-highlight  m-3 align-items-center"data-bs-target="#nop-don" data-bs-toggle="modal">
                        <span class="text-center m-auto">Nộp đơn </span>
                    </span>';
        }
        else if(ktDangDuyet($manv)){
            return '<span class="btn  p-2 btn-primary btn-chucnang w-100  bd-highlight  m-3 align-items-center"data-bs-target="#thong-bao-dang-duyet" data-bs-toggle="modal">
                        <span class="text-center m-auto">Nộp đơn </span>
                    </span>';
        }else if( ((strtotime(date('Y-m-d')) - strtotime(ngayDuyetCuoi($manv))) / (60*60*24)) < 7  ){
            return '<span class="btn  p-2 btn-primary btn-chucnang w-100  bd-highlight  m-3 align-items-center"data-bs-target="#thong-bao-cho" data-bs-toggle="modal">
                        <span class="text-center m-auto">Nộp đơn </span>
                    </span>';
        }else {
            return '<span class="btn  p-2 btn-primary btn-chucnang w-100  bd-highlight  m-3 align-items-center"data-bs-target="#nop-don" data-bs-toggle="modal">
                        <span class="text-center m-auto">Nộp đơn </span>
                    </span>';
        }
        return;
    }
?>