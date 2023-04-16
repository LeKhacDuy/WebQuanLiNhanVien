<?php
  session_start();
  if (!isset($_SESSION['taikhoan']) && !isset($_SESSION['manv'])) {
    header('Location: ../login.php');
    exit();
  }
  if(password_verify($_SESSION['taikhoan'],$_SESSION['matkhau'])){
    header('Location: ../first.php');
    exit();
  }
  if($_SESSION['chucvu'] == 0){
    header('Location: ../nhanvien/index.php');
        exit();
  }
  if($_SESSION['chucvu'] == 1){
    header('Location: ../truongphong/index.php');
        exit();
  } 
  require_once('../database/conf.php');
  include('../header.php');
  $allPB = json_decode(layPB()) ->data;
  $allNV = json_decode(layNV()) ->data;
?>
<body>
    <?php
        include('../navbar.php');
        
        include('slidebar.php');
    ?>
     <main class="mt-5 pt-3">
     <div class="button-add d-flex justify-content-end">

            <span class="btn btn-primary d-flex p-2 bd-highlight  m-3 align-items-center"data-bs-target="#themNV" data-bs-toggle="modal">
                <span>Thêm nhân viên</span>
            </span>
        </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Danh sách nhân viên
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="example"
                    class="table table-striped data-table"
                    style="width: 100%">
                    <thead>
                      <tr class="text-center ">
                        <th>Mã nhân viên</th>
                        <th>Tên nhân viên</th>
                        <th>Phòng ban</th>
                        <th>Chức vụ</th>
                        <th>Lương</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody class="pb text-center">                                        
                        <?php foreach($allNV as $nhanvien) { ?>
                          <?php if($nhanvien -> chucvu != 2) { ?>
                            <tr class="align-middle"> 
                                <td><?=$nhanvien -> manv ?></td>
                                <td><?=$nhanvien -> ten ?></td>
                                <td><?=tenPB($nhanvien -> mapb) ?></td>
                                <td><?=chucVu($nhanvien -> chucvu) ?></td>
                                <td><?=$nhanvien ->luong ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-chucnang w-100 m-1" data-bs-toggle="modal" data-bs-target="#nv<?=$nhanvien->manv?>">
                                    Chi tiết
                                    </button>
                                    <button type="button" class="btn btn-danger btn-chucnang w-100"  data-bs-toggle="modal" data-bs-target="#xoa-nv<?=$nhanvien->manv?>">Xóa</button>
                                </td>      
                                <div class="modal fade " id="nv<?=$nhanvien->manv?>">
                                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">Thông tin nhân viên <?=$nhanvien->ten?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>

                                      <!-- Modal body -->
                                      <form action="" method="post" id="chitiet-<?=$nhanvien->manv?>" enctype="multipart/form-data">
                                        <div class="modal-body">
                                        <div class="mb-3">
                                            <img class="img-fluid rounded mx-auto d-block" src="<?=$nhanvien->img?>" alt="ảnh nhân viên <?=$nhanvien->ten?>"?>
                                          </div>
                                          <div class="mb-3">
                                            <label class="form-label">Mã nhân viên: <?=$nhanvien->manv?></label>
                                            
                                          </div>
                                          <div class="mb-3">
                                            <label class="form-label">Tên nhân viên: <?=$nhanvien->ten?></label>
                                            
                                          </div>
                                          <div class="mb-3">
                                            <label class="form-label">Tên tài khoản: <?=$nhanvien->taikhoan?></label>
                                            
                                          </div>
                                          <div class="mb-3">
                                            <label class="form-label">Địa chỉ email: <?=$nhanvien->email?></label>
                                            
                                          </div >
                                          <div class="mb-3">
                                            <label class="form-label">Phòng ban: <?=tenPB($nhanvien -> mapb)?></label>
                                            
                                          </div >
                                          <div class="mb-3">
                                            <label class="form-label">Chức vụ:    </label>  <?=chucVu($nhanvien -> chucvu)?>
                                            
                                          </div >
                                          <div class="mb-3">
                                            <label class="form-label">Lương: <?=$nhanvien->luong?></label>                          
                                          </div >
                                          <div class="mb-3">
                                            <label class="form-label">Số ngày nghỉ phép còn lại: <?=$nhanvien->ngaynghi?></label>                          
                                          </div >
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#reset-nv<?=$nhanvien->manv?>">Reset mật khẩu</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                  
                                </div> 
                                <div class="modal fade" id="xoa-nv<?=$nhanvien->manv?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">       
                                              <h5 class="modal-title">Xóa nhân viên <?=$nhanvien->ten?></h5>
                                        </div>
                                              
                                        <div class="modal-body">
                                              Bạn chắc chắn có muốn xóa nhân viên <?=$nhanvien->ten?> không ?
                                        </div>
                                        <form action="" id="form-xoaNV-nv<?=$nhanvien->manv?>">   
                                          <div class="modal-footer">
                                              <input type="number" name="manv" value="<?=$nhanvien->manv?>" hidden/>
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                              <button type="submit" onclick="xoaNV('form-xoaNV-nv<?=$nhanvien->manv?>')"class="btn btn-danger btn-ok">Xóa</a>
                                          </div>
                                        </form>   
                                    </div>
                                  </div>
                                </div>
                                <div class="modal fade" id="reset-nv<?=$nhanvien->manv?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">       
                                              <h5 class="modal-title">Reset mật khẩu của nhân viên <?=$nhanvien->ten?></h5>
                                        </div>
                                              
                                        <div class="modal-body">
                                              Bạn chắc chắn có muốn reset mật khẩu của <?=$nhanvien->ten?> không ?
                                        </div>
                                        <form action="" method="POST" id="form-resetMK-nv<?=$nhanvien->manv?>">   
                                          <div class="modal-footer">
                                              <input type="number" name="manv" value="<?=$nhanvien->manv?>" hidden/>
                                              <input type="text" name="taikhoan" value="<?=$nhanvien->taikhoan?>" hidden/>
                                              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#nv<?=$nhanvien->manv?>" data-bs-dismiss="modal">Hủy</button>
                                              <button type="submit" onclick="resetMK('form-resetMK-nv<?=$nhanvien->manv?>')" class="btn btn-danger btn-ok">Reset</a>
                                          </div>
                                        </form>   
                                    </div>
                                  </div>
                                </div>
                            </tr>
                          <?php } ?>
                        <?php } ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- The Modal thong tin -->
    <div class="modal fade " id="themNV">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Thêm nhân viên</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <form action="" method="post" id="form-themNV" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Tên nhân viên</label>
                
                <input type="text" class="form-control" id="TenNV"  placeholder="Tên nhân viên" name="ten" />
                
              </div>
              <div class="mb-3">
                <label class="form-label">Tên tài khoản</label>
                <input type="text" class="form-control" id="TenTK"  placeholder="Tên tài khoản" name="taikhoan" />
                
              </div>
              <div class="mb-3">
                <label class="form-label">Địa chỉ email</label>
                <input type="text" class="form-control" id="dcmail"  placeholder="Email" name="email"/>
                
              </div >
              <div class="mb-3">
                <label class="form-label">Phòng ban</label>
                <select class="form-select" aria-label="" name="mapb" id="mapb">
                    <!-- <option selected>Chọn phòng ban</option> -->
                    <?php foreach($allPB as $phongban) {?>
                        <?php if($phongban-> mapb !=0) { ?>
                          <option value="<?=$phongban->mapb?>"><?=$phongban -> tenpb?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
              </div >
              <div class="mb-3">
                <label class="form-label">Lương</label>
                <input type="number" class="form-control" id="Luong" placeholder="Lương" name="luong"/>
                
              </div >
              <div id="error" class="mb-3  mt-2 text-danger p-2"></div>
            </div>
            <div class="modal-footer">      
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit"  id="btn-themNV" class="btn btn-primary">Lưu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    

    <script src="../main.js"></script>
</body>

