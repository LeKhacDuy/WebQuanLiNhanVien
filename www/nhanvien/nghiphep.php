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
	if($_SESSION['chucvu'] == 1){
		header('Location: ../truongphong/index.php');
        exit();
	}
	if($_SESSION['chucvu'] == 2){
		header('Location: ../giamdoc/index.php');
        exit();
	} 
	
	include('../header.php');
    $allNghiPhep = json_decode(layNghiPhep_manv($nhanvien['manv'])) -> data;
    
?>
<body>
    <?php
        include('../navbar.php');
        
        include('slidebar.php');
    ?>

     <main class="mt-5 pt-3 ">    
        <div class="button-add d-flex fw-bold justify-content-between">
            <span class=" p-2 bd-highlight  m-3 align-items-center ">
                <span>Tổng số ngày nghỉ phép: <?= ($nhanvien['chucvu'] == 0) ? 12 : 15 ?> </span>
            </span>
            <span class=" p-2 bd-highlight  m-3 align-items-center ">
                <span>Số ngày nghỉ phép còn lại: <?=$nhanvien['ngaynghi'] ?> </span>
            </span>
            <span class=" p-2 bd-highlight  m-3 align-items-center ">
                <span>Số ngày đã sử dụng: <?= ($nhanvien['chucvu'] == 0) ? 12 - $nhanvien['ngaynghi'] : 15 - $nhanvien['ngaynghi'] ?>  </span>
            </span>
            
            <?=ktBtnNopDon($nhanvien['manv'])?>

        </div>
        <div class="container-fluid ">
            <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                <div class="card-header">
                    <span><i class="bi bi-table me-2"></i></span> Danh sách các đơn xin nghỉ phép của bạn
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
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>                                       
                                    </div>
                                </div>
                                
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
                    <select class="form-select" name="songaynghi" id="songaynghi">
                        <?php for($i = 1; $i <= $nhanvien['ngaynghi']; $i++) {?>
                            <option value="<?=$i?>"><?=$i?></option>
                        <?php } ?>
                    </select>           
                </div>               
                <div class="mb-3">
                    <label class="form-label">Lý do:  </label>
                    <textarea class="form-control" name="mota" id="lydo" rows="5" required></textarea>
                </div>           
                <div class="mb-3">
                  <label for="formFile" class="form-label">Gửi tệp đính kèm</label>
                  <input type="file" class="form-control" id="file" name="file">
                </div>
                <p class="fst-italic">*Lưu ý: Chỉ có thể nộp file có định dạng .txt, .pdf, .zip, .rar, .docx, .xlsx, .pptx, .doc (dung lượng tối đa 20mb)</p>
                <div id="errorngaynghi" class="mb-3  mt-2 text-danger p-2"></div>
            </div>
            <div class="modal-footer">      
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit"  id="btn-nop-don" class="btn btn-primary">Nộp</button>
            </div>
                          
          </form>
        </div>
      </div>
    </div>
    <!-- Đang duyệt -->
    <div class="modal fade " id="thong-bao-dang-duyet">
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
                <label for="">Bạn không thể nộp đơn trong lúc đang chờ duyệt đơn !</label>
            </div>
        </div>
        <div class="modal-footer">      
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
                          
          
        </div>
      </div>
    </div>     
    <!-- Chờ -->
    <div class="modal fade " id="thong-bao-cho">
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
                <label for="">Bạn chỉ có thể nộp đơn tiếp sau 7 ngày kể từ lúc nhận kết quả phê duyệt !</label>
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