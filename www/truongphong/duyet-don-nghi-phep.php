<?php
  session_start();
	
  if (!isset($_SESSION['taikhoan']) && !isset($_SESSION['manv'])) {
    header('Location: ../login.php');
    exit();
    }
    require_once('../database/conf.php');
    $nhanvien = lay1NV_manv($_SESSION['manv']);

    if(password_verify($nhanvien['taikhoan'],$nhanvien['matkhau'])){
        header('Location: ../first.php');
        exit();
    }

    if($_SESSION['chucvu'] == 0){
        header('Location: ../nhanvien/index.php');
        exit();
    }
    if($_SESSION['chucvu'] == 2){
        header('Location: ../giamdoc/index.php');
        exit();
    } 
	
	include('../header.php');
    $allNghiPhep = json_decode(layNghiPhep_mapb($nhanvien['mapb'])) -> data;
    
?>
<body>
    <?php
        include('../navbar.php');
        
        include('slidebar.php');
    ?>

     <main class="mt-5 pt-3  ">    
        <div class="container-fluid mt-5 ">
            <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                <div class="card-header">
                    <span><i class="bi bi-table me-2"></i></span> Danh sách các đơn xin nghỉ phép của nhân viên
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="example" class="table table-striped data-table"  style="width: 100%">
                        <thead>
                        <tr class="text-center ">
                            <th>Mã đơn</th>
                            <th>Nhân viên</th>
                            <th>Số ngày xin nghỉ</th>
                            <th>Ngày gửi</th>
                            <th>Ngày phê duyệt</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody class="pb text-center">                                        
                            <?php foreach($allNghiPhep as $nghiphep) { ?>
                                <?php if($nghiphep-> manv != $nhanvien['manv']) { ?> 
                                    <tr class="align-middle"> 
                                        <td><?=$nghiphep->id?></td>
                                        <td><?=truongPhong($nghiphep->manv)?></td>
                                        <td><?=$nghiphep->songaynghi?></td>
                                        <td><?=date("d-m-Y", strtotime($nghiphep->ngaygui))?></td>
                                        <td><?=ngayDuyet($nghiphep->ngayduyet)?></td>
                                        <td><?=trangThaiDuyet($nghiphep->trangthai)?></td>
                                        <td>
                                            <button type="button" class="btn btn-chucnang btn-primary w-100 m-1" data-bs-toggle="modal" data-bs-target="#don-<?=$nghiphep->id?>">
                                            Thông tin
                                            </button>                     
                                        </td>      
                                                                                        
                                    </tr>      
                                    <div class="modal fade " id="don-<?=$nghiphep->id?>">
                                        <div class="modal-dialog modal-dialog-centered  modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Thông tin đơn nghỉ phép </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <!-- Modal body -->
                                        
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Mã đơn: <?=$nghiphep->id?> </label>                                        
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nhân viên gửi: <?=truongPhong($nghiphep->manv)?> </label>
                                                </div >
                                                <div class="mb-3">
                                                    <label class="form-label">Ngày nộp: <?=  date("d-m-Y", strtotime($nghiphep -> ngaygui )) ?>  </label>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Ngày duyệt: <?=ngayDuyet($nghiphep->ngayduyet)?></label>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tệp đính kèm: <?=download($nghiphep->file)?></label>
                                                </div >
                                                <div class="mb-3">
                                                    <label class="form-label">Trạng thái: <?=trangThaiDuyetText($nghiphep->trangthai)?></label>
                                                </div >
                                                <div class="mb-3">
                                                    <label class="form-label">Nội dung: </label>
                                                    <textarea class="form-control " name="mota" rows="6" placeholder="" disabled> <?=$nghiphep->mota?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">      
                                                
                                                <?php if($nghiphep-> trangthai == 0 ) { ?> 
                                                    <button type="button" class="btn btn-chucvu w-100 btn-danger" data-bs-toggle="modal" data-bs-dismiss="modal"  data-bs-target="#khong-duyet-don-<?=$nghiphep->id?>">Không duyệt</button>
                                                    <button type="button" class="btn btn-chucvu w-100 btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal"  data-bs-target="#duyet-don-<?=$nghiphep->id?>">Duyệt</button>
                                                <?php } ?>
                                            </div>     
                                            </div>                                  
                                        </div>
                                    </div>
                                    <?php if($nghiphep-> trangthai == 0 ) { ?>                
                                        <div class="modal fade " id="khong-duyet-don-<?=$nghiphep->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Thông báo</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    
                                                    <div class="modal-body">
                                                        <div class="m-3">
                                                            <label for="">Bạn có chắc chắn là không duyệt đơn xin nghỉ phép của nhân viên <strong><?=truongPhong($nghiphep->manv)?></strong> không ? </label>
                                                        </div>
                                                    </div>
                                                    <!-- footer -->
                                                    <div class="modal-footer">      
                                                        
                                                        <form action="" method="post" id="form-khong-duyet-<?=$nghiphep->id?>"  enctype="multipart/form-data">
                                                            <input type="number" value="<?=$nghiphep->id?>" name="id" hidden>
                                                            <input type="number" value="<?=$nghiphep->manv?>" name="manv" hidden>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Hủy</button>
                                                            <button type="submit" class="btn btn-primary" onclick="khongDuyet('form-khong-duyet-<?=$nghiphep->id?>')">Xác nhận</button>
                                                        </form>
                                                    </div>
                                                                                                        
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="modal fade " id="duyet-don-<?=$nghiphep->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Thông báo</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    
                                                    <div class="modal-body">
                                                        <div class="m-3">
                                                            <label for="">Bạn có chắc chắn là duyệt đơn xin nghỉ phép của nhân viên <strong><?=truongPhong($nghiphep->manv)?></strong> không ? </label>
                                                        </div>
                                                    </div>
                                                    <!-- footer -->
                                                    <div class="modal-footer">      
                                                        
                                                        <form action="" method="post" id="form-duyet-<?=$nghiphep->id?>"  enctype="multipart/form-data">
                                                            <input type="number" value="<?=$nghiphep->id?>" name="id" hidden>
                                                            <input type="number" value="<?=$nghiphep->manv?>" name="manv" hidden>
                                                            <input type="number" value="<?=$nghiphep->songaynghi?>" name="songaynghi" hidden>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Hủy</button>
                                                            <button type="submit" class="btn btn-primary" onclick="duyet('form-duyet-<?=$nghiphep->id?>')">Xác nhận</button>
                                                        </form>
                                                    </div>
                                                                                                        
                                                </div>
                                            </div>
                                        </div> 
                                    <?php } ?>
                                <?php } ?>
                            <?php }?>
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

    <div class="modal fade " id="nop-don">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Nộp đơn xin nghỉ phép</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <form action="" method="post" id="form-nop-don" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="mb-3">
                    <input class="form-control" type="number" value="<?=$nhanvien['manv']?>" name="manv" hidden>
                </div> 
                <div class="mb-3 form-group">
                    <label class="form-label">Chọn số ngày nghỉ:  </label>
                    <select class="form-select" name="songaynghi" >
                        <?php for($i = 1; $i <= $nhanvien['ngaynghi']; $i++) {?>
                            <option value="<?=$i?>"><?=$i?></option>
                        <?php } ?>
                    </select>           
                </div>               
                <div class="mb-3">
                    <label class="form-label">Lý do:  </label>
                    <textarea class="form-control" name="mota" rows="5" required></textarea>
                </div>           
                <div class="mb-3">
                  <label for="formFile" class="form-label">Gửi tệp đính kèm</label>
                  <input type="file" class="form-control" id="file" name="file">
                </div>
                <p class="fst-italic">*Lưu ý: Chỉ có thể nộp file có định dạng .txt, .pdf, .zip, .rar, .docx, .xlsx, .pptx, .doc (dung lượng tối đa 20mb)</p>
         
            </div>
            <div class="modal-footer">      
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit"  id="btn-nop-don" class="btn btn-primary">Nộp</button>
            </div>
                          
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade " id="thong-bao-btn">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Thông báo</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          
        <div class="modal-body">
            <div class="m-3">
                <label for="">Bạn chỉ có thể nộp đơn tiếp sau 7 ngày kể từ lúc duyệt !</label>
            </div>
        </div>
        <div class="modal-footer">      
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            
        </div>
                          
          
        </div>
      </div>
    </div>                      
    <script src="../main.js"></script>
</body>