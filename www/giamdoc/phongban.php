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
?>
<body>
    <?php
        include('../navbar.php');
        
        include('slidebar.php');
    ?>
     <main class="mt-5 pt-3">
     <div class="button-add d-flex justify-content-end">
            <span class="btn btn-primary d-flex p-2 bd-highlight  m-3 align-items-center"data-bs-target="#themPB"
                data-bs-toggle="modal">

                <span>Thêm phòng ban</span>
            </span>
        </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Dannh sách phòng ban
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="example"
                    class="table table-striped data-table"
                    style="width: 100%">
                    <thead>
                      <tr class="text-center ">
                        <th>Số thứ tự</th>
                        <th>Tên phòng ban</th>
                        <th>Trưởng phòng</th>
                        <th>Số lượng nhân viên</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody class="pb text-center">
                      <?php foreach($allPB as $phongban) {?>
                        <?php if($phongban->mapb != 0) { ?>
                          <tr class="align-middle">
                            <td><?=$phongban->stt?></td>
                            <td><?=$phongban->tenpb?></td>
                            <td><?= truongPhong($phongban->truongphong)?></td>
                            <td><?= soLuongNV($phongban->mapb) ?> người</td>
                            <td>
                              <button type="button" class="btn btn-primary btn-chucnang w-100 m-1" data-bs-toggle="modal" data-bs-target="#pb<?=$phongban->mapb?>">
                                Chi tiết
                              </button>
                              <button type="button" class="btn btn-danger btn-chucnang w-100  " data-bs-toggle="modal" data-bs-target="#xoa-pb<?=$phongban->mapb?>">Xóa</button>
                            </td>
                            <!-- The Modal sửa phòng ban -->
                            <div class="modal fade " id="pb<?=$phongban->mapb?>">
                              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                  <?php $nhanvienPB = json_decode(layNV_mapb($phongban->mapb)) ->data ?>
                                  <!-- Modal Header -->

                                  <div class="modal-header">
                                    <h4 class="modal-title">Phòng ban <?=$phongban->tenpb?></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>

                                  <!-- Modal body -->
                                  <form action="" method="post" id="form-suaPB-pb<?=$phongban->mapb?>" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="number" class="form-control" value="<?=$phongban->mapb?>" name="mapb" hidden />
                                      <div class="mb-3">
                                        <label class="form-label">Số thứ tự phòng ban</label>
                                      <input type="number" class="form-control" value="<?=$phongban->stt?>" name="stt"/>
                                      </div>
                                      <div class="mb-3">
                                        <label class="form-label">Tên phòng ban</label>
                                        <input type="text" class="form-control"  value="<?=$phongban->tenpb?>" name="tenpb"/>
                                      </div >
                                      <div class="mb-3">
                                        <label class="form-label">Trưởng phòng</label>
                                        <select class="form-select" aria-label="" name="truongphong">
                                            <?php if($phongban-> truongphong == 0){?>
                                                <option selected value="0">Chưa có</option>
                                            <?php }?>
                                                    
                                            <?php foreach($nhanvienPB as $nhanvien) {?>
                                                
                                                <?php if($nhanvien-> manv == $phongban-> truongphong){?>
                                                          <option selected value="<?=$nhanvien->manv?>"><?=$nhanvien -> ten?></option>
                                                <?php } else {?>
                                                          <option value="<?=$nhanvien->manv?>"><?=$nhanvien -> ten?></option>
                                                <?php } ?>
                                                
                                            <?php } ?>
                                        </select>
                                      </div >
                                      <div class="mb-3">
                                        <label class="form-label">Mô tả</label>
                                        <textarea class="form-control"  rows="3" name="mota"><?=$phongban->mota?></textarea>
                                      </div>
                                    </div>
                                    <div class="modal-footer">                     
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ bỏ</button>
                                        <button type="submit" onclick="suaPB('form-suaPB-pb<?=$phongban->mapb?>')" class="btn btn-primary">Lưu</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>          

                            <div class="modal fade" id="xoa-pb<?=$phongban->mapb?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                            
                                            <h5 class="modal-title">Xóa phòng ban <?=$phongban->tenpb?></h5>
                                      </div>
                                            
                                      <div class="modal-body">
                                            Bạn chắc chắn có muốn xóa phòng ban <?=$phongban->tenpb?> không ?
                                      </div>
                                      <form action="" id="form-xoaPB-pb<?=$phongban->mapb?>">   
                                        <div class="modal-footer">
                                            <input type="number" name="mapb" value="<?= $phongban->mapb?>" hidden/>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" onclick="xoaPB('form-xoaPB-pb<?=$phongban->mapb?>')" class="btn btn-danger btn-ok">Delete</a>
                                        </div>
                                      </form>   
                                  </div>
                              </div>
                            </div>          
                          </tr>
                        <?php } ?>                         
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- The Modal thêm phòng ban -->
    <div class="modal fade " id="themPB">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Thêm phòng ban</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <form action="" method="post" id="form-themPB" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Số thứ tự phòng ban</label>
              <input type="number" class="form-control" id="Stt"  placeholder="Số thứ tự" name="stt"/>
              </div>
              <div class="mb-3">
                <label class="form-label">Tên phòng ban</label>
              <input type="text" class="form-control" id="Tenpb" placeholder="Tên phòng ban" name="tenpb"
                />
              </div >
              <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" id="Mota" rows="3" name="mota"></textarea>
              </div>
            </div>
            <div id="errorPb" class="mb-3   text-danger p-2"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ bỏ</button>
                <button type="submit" id="btn-themPB" class="btn btn-primary">Lưu</button>
            </div>
          </form>
        </div>
      </div>
    </div>
     
    <script src="../main.js"></script>
</body>

