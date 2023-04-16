<?php
  session_start();
	ob_start();
    if (!isset($_SESSION['taikhoan']) && !isset($_SESSION['manv'])) {
        header('Location: ../login.php');
        exit();

    }

    if(!isset($_GET['ma_task'])){
        header('Location: task.php');
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

    if(!kiemTraChiTietTask($_GET['ma_task'], $nhanvien['mapb'] )) {
        header('Location: task.php');
        exit();
    }

	include('../header.php');

    $allChiTietTask = json_decode(layChiTietTask_ma_task($_GET['ma_task'])) -> data;
    $task = lay1Task_ma_task($_GET['ma_task']) ;
	
?>
<body>
    <?php
        include('../navbar.php');
        
        include('slidebar.php');
    ?>
     <main class="mt-5 pt-3 ">

      <div class="container-fluid mt-5">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Danh sách chi tiết task
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example" class="table table-striped data-table" style="width: 100%">
                    <thead>
                      <tr class="text-center ">
                        <th>Số thứ tự</th>
                        <th>Tiêu đề</th>
                        <th>Nhân viên</th>
                        <th>Ngày nộp</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody class="pb text-center">       
                                                        
                        <?php foreach($allChiTietTask as $ctTask) { ?>
                            <tr class="align-middle"> 
                                <td><?=$ctTask -> stt ?></td>
                                <td><?=$task['ten'] ?></td>
                                <td><?=truongPhong($task['manv'])?></td>
                                <td><?=date("d-m-Y", strtotime($ctTask -> ngaynop )) ?></td>
                                <td><?=trangThaiDuyet($ctTask->duyet) ?></td>
                                <td>
                                    <button type="button" class="btn btn-chucnang btn-primary w-100 m-1" data-bs-toggle="modal" data-bs-target="#task-<?=$ctTask->stt?>">
                                    Thông tin
                                    </button>    
                                    <?php if($ctTask->duyet == 1){ ?>
                                        <button type="button" class="btn btn-chucnang btn-info text-light w-100 m-1" data-bs-toggle="modal" data-bs-target="#phanhoi-task-<?=$ctTask->stt?>">
                                          Phản hồi
                                        </button>  
                                    <?php } else if($ctTask -> duyet == 2) {?>          
                                      <button type="button" class="btn btn-chucnang btn-warning  w-100 m-1" data-bs-toggle="modal" data-bs-target="#danhgia-task-<?=$ctTask->stt?>">
                                          Đánh giá
                                        </button>  
                                    <?php } ?>                   
                                </td>      
                                                                                
                            </tr>
                            <!-- Chi tiết task -->
                            <div class="modal fade " id="task-<?=$ctTask->stt?>">
                              <div class="modal-dialog modal-dialog-centered  modal-lg modal-dialog-scrollable">
                                  <div class="modal-content">

                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                      <h4 class="modal-title">Thông tin chi tiết task </h4>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>

                                  <!-- Modal body -->
                                  <div class="modal-body">
                                      <div class="mb-3">
                                          <label class="form-label">Lần submit: <?=$ctTask->stt?> </label>                                        
                                      </div>
                                      <div class="mb-3">
                                          <label class="form-label">Nhân viên thực hiện: <?=truongPhong($task['manv'])?> </label>
                                      </div >
                                      <div class="mb-3">
                                          <label class="form-label">Ngày nộp: <?=  date("d-m-Y", strtotime($ctTask -> ngaynop )) ?>  </label>
                                      </div>
                                      <div class="mb-3">
                                          <label class="form-label">Ngày hết hạn nhiệm vụ (deadline): <?=date("d-m-Y", strtotime($task['deadline']))  ?> </label>
                                      </div>
                                      <div class="mb-3">
                                          <label class="form-label">Tệp đính kèm: <?=download($ctTask->filenhanvien)?></label>
                                      </div >
                                      <div class="mb-3">
                                          <label class="form-label">Nội dung: </label>
                                          <textarea class="form-control " name="mota" rows="6" placeholder="" disabled> <?=$ctTask->mota?></textarea>
                                      </div>
                                  </div>
                                  <div class="modal-footer">      
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                      <?php if($ctTask-> duyet == 0 ) { ?> 
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-dismiss="modal"  data-bs-target="#reject-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>">Không duyệt task</button>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal"  data-bs-target="#approve-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>">Duyệt task</button>
                                      <?php } ?>
                                  </div>
                                  </div>
                              </div>
                            </div>
                            <?php if($ctTask->duyet ==0 ) { ?>
                              <!-- Không duyệt task -->
                              <div class="modal fade" id="reject-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title fw-bold">Không duyệt task</h4>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <form action="" method="post" id="form-reject-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>" enctype="multipart/form-data">
                                      <div class="modal-body">
                                          <div class="mb-3">
                                              <input class="form-control" type="number" value="<?=$task['ma_task']?>" name="ma_task" hidden>
                                              <input class="form-control" type="number" value="<?=$ctTask->stt?>" name="stt" hidden>

                                          </div> 
                                          <div class="mb-3">
                                              <label class="form-label">Gia hạn deadline: </label>
                                              <input type="number" value="0" class="form-control" name="giahan" rows="5" min="0" required>
                                          </div>
                                          <div class="mb-3">
                                              <label class="form-label">Phản hồi </label>
                                              <textarea class="form-control" name="feedback" rows="5" required></textarea>
                                          </div>           
                                          
                                          <div class="mb-3">
                                            <label for="formFile" class="form-label">Gửi tệp đính kèm</label>
                                            <input type="file" class="form-control" id="filetruongphong" name="filetruongphong">
                                          </div>
                                          <p class="fst-italic">*Lưu ý: Chỉ có thể nộp file có định dạng .txt, .pdf, .zip, .rar, .docx, .xlsx, .pptx, .doc (dung lượng tối đa 20mb)</p>
                                  
                                      </div>
                                      <div class="modal-footer">      
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                          <button type="submit" class="btn btn-primary" onclick="rejectTask('form-reject-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>')">Xác nhận</button>
                                      </div>
                                                    
                                    </form>
                                  </div>
                                </div>
                              </div>
                              <!-- Duyệt task -->
                              <div class="modal fade" id="approve-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title fw-bold">Duyệt task</h4>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <form class="form-danhgia" action="" method="post" id="form-approve-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>" enctype="multipart/form-data">
                                      <div class="modal-body">
                                          <div class="mb-4">
                                              <input class="form-control" type="number" value="<?=$task['ma_task']?>" name="ma_task" hidden>
                                              <input class="form-control" type="number" value="<?=$ctTask->stt?>" name="stt" hidden>
                                              <label class="fs-5" for="">Đánh giá task nhân viên <?=truongPhong($task['manv'])?> </label>
                                          </div> 
                                          <div class="mb-4">
                                              <label class="fs-5" for="">Tình trạng nộp: <?=ktDeadline($ctTask -> ngaynop,$task['deadline'])?>  </label>
                                          </div> 
                                          <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
                                            <?php if(ktDanhGia($ctTask -> ngaynop,$task['deadline'])) {?>
                                                <input type="radio" class="btn-check " id="bad" name="danhgia" iautocomplete="off" value="0"checked>
                                                <label class="btn btn-outline-danger" for="bad">Bad</label>

                                                <input type="radio" class="btn-check" id="ok" name="danhgia" value="1" autocomplete="off">
                                                <label class="btn btn-outline-warning" for="ok">Ok</label>

                                                <input type="radio" class="btn-check" id="good" name="danhgia" value="2" autocomplete="off">
                                                <label class="btn btn-outline-success" for="good">Good</label>
                                            <?php } else { ?>
                                                <input type="radio" class="btn-check " id="bad" name="danhgia" autocomplete="off" value="0"checked>
                                                <label class="btn btn-outline-danger" for="bad">Bad</label>

                                                <input type="radio" class="btn-check" id="ok" name="danhgia" value="1" autocomplete="off">
                                                <label class="btn btn-outline-warning" for="ok">Ok</label>
                                            <?php } ?>
                                          </div>          
                                      </div>
                                      <div class="modal-footer">      
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                          <button type="submit" class="btn btn-primary" onclick="approveTask('form-approve-task-<?=$ctTask->ma_task?>-<?=$ctTask->stt?>')">Xác nhận</button>
                                      </div>
                                                    
                                    </form>
                                  </div>
                                </div>
                              </div>
                            <?php } ?>
                            <?php if($ctTask->duyet == 1){ ?>
                              <div class="modal fade " id="phanhoi-task-<?=$ctTask->stt?>">
                                <div class="modal-dialog modal-dialog-centered  modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Phản hồi từ trưởng phòng </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Task: <?=$task['ten']?></label>
                                        </div >
                                        <div class="mb-3">
                                            <label class="form-label">Nội dung: </label>
                                            <textarea class="form-control " name="feedback" rows="6" placeholder="" disabled> <?=$ctTask->feedback?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tệp đính kèm: <?=download($ctTask->filetruongphong)?></label>
                                        </div >
                                    </div>
                                    <div class="modal-footer">      
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>

                                    </div>
                                </div>
                              </div>
                            <?php } else if($ctTask -> duyet == 2) {?>          
                              <div class="modal fade " id="danhgia-task-<?=$ctTask->stt?>">
                                <div class="modal-dialog modal-dialog-centered  modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Đánh giá từ trưởng phòng </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Task: <?=$task['ten']?></label>
                                        </div >
                                        <div class="mb-3">
                                              <label class="" for="">Tình trạng nộp: <?=ktDeadline($ctTask -> ngaynop,$task['deadline'])?>  </label>
                                        </div> 
                                        <div class="mb-3">
                                              <label class="" for="">Đánh giá: <?=($ctTask->danhgia == 0) ? 'Bad' : (($ctTask->danhgia == 1) ? 'Ok' : 'Good' ) ?> </label>
                                        </div> 
                                    </div>
                                    <div class="modal-footer">      
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>

                                    </div>
                                </div>
                              </div>
                            <?php } ?>  
                        <?php }?>
                      

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </main>
    
    
                                        
    <script src="../main.js"></script>
</body>