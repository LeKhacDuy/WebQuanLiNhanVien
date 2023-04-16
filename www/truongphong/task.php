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

    $allTask = json_decode( layTask_mapb($nhanvien['mapb'])) -> data;
    $nhanvienPB = json_decode(layNV_mapb($nhanvien['mapb'])) ->data
	
?>
<body>
    <?php
        include('../navbar.php');
        
        include('slidebar.php');
    ?>

     <main class="mt-5 pt-3">    
     <div class="button-add d-flex justify-content-end">
            <span class="btn btn-primary d-flex p-2 bd-highlight  m-3 align-items-center"data-bs-target="#taoTask" data-bs-toggle="modal">
                <span>Tạo task mới</span>
            </span>
        </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
                <span><i class="bi bi-table me-2"></i></span> Danh sách các nhiệm vụ (task)
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example" class="table table-striped data-table"  style="width: 100%">
                    <thead>
                      <tr class="text-center ">
                        <th>Mã task</th>
                        <th>Tiêu đề</th>
                        <th>Nhân viên</th>
                        <th>Ngày hết hạn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                      </tr>
                    </thead>
                    <tbody class="pb text-center">       
                                                        
                        <?php foreach($allTask as $task) { ?>
                            <tr class="align-middle"> 
                                <td><?=$task -> ma_task ?></td>
                                <td><?=$task -> ten ?></td>
                                <td><?=truongPhong($task -> manv)?></td>
                                <td><?=date("d-m-Y", strtotime($task -> deadline)) ?></td>
                                <td><?=trangThaiTask($task-> trangthai)?></td>
                                <td>
                                    <button type="button" class="btn btn-chucnang btn-primary w-100 m-1" data-bs-toggle="modal" data-bs-target="#task-<?=$task->ma_task?>">
                                    Thông tin
                                    </button>
                                    <?php if($task-> trangthai == 0){ ?>
                                        <button type="button" class="btn btn-chucnang btn-danger w-100 m-1"  data-bs-toggle="modal" data-bs-target="#huy-task-<?=$task->ma_task?>">Hủy</button>
                                    <?php } ?>         
                                    <?php if($task-> trangthai > 0){ ?>
                                        <a type="button" href="chitiet-task.php?ma_task=<?=$task -> ma_task?>" class="btn btn-chucnang btn-warning w-100 m-1 "  >Chi tiết</a>
                                    <?php } ?>                       
                                </td>      
                                                                                
                            </tr>
                            <!-- Chi tiết task -->
                            <div class="modal fade " id="task-<?=$task->ma_task?>">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Thông tin task <?=$task -> ten?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Tiêu đề: <?=$task -> ten?> </label>                                        
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nhân viên thực hiện: <?=truongPhong($task -> manv)?></label>
                                        </div >
                                        <div class="mb-3">
                                            <label class="form-label">Ngày hết hạn nhiệm vụ (deadline): <?=$task -> deadline ?></label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mô tả nhiệm vụ</label>
                                            <textarea class="form-control " name="mota" rows="4" placeholder="<?=$task -> mota?>" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">      
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Hủy task -->
                            <?php if($task-> trangthai ==0) {?>
                                <div class="modal fade" id="huy-task-<?=$task->ma_task?>" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">    
                                                    <h5 class="modal-title">Hủy task <?=$task->ten?></h5>
                                            </div>
                                                    
                                            <div class="modal-body">
                                                    Bạn chắc chắn có muốn hủy task  <?=$task->ten?> không ?
                                            </div>
                                            <form action="" id="form-huy-task<?=$task->ma_task?>">   
                                                <div class="modal-footer">
                                                    <input type="number" name="ma_task" value="<?= $task->ma_task?>" hidden/>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" onclick="huyTask('form-huy-task<?=$task->ma_task?>')"class="btn btn-primary btn-ok">Xác nhận</a>
                                                </div>
                                            </form>   
                                        </div>
                                    </div>
                                </div> 
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
    <!-- The Modal thong tin -->
    <div class="modal fade " id="taoTask">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Tạo task mới</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <form action="" method="post" id="form-taoTask" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="number" name="mapb" value="<?=$nhanvien['mapb']?>" hidden>
                <div class="mb-3">
                    <label class="form-label">Tiêu đề nhiệm vụ</label>
                    <input type="text" class="form-control" id="tentask"  placeholder="Tiêu đề" name="ten" required/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nhân viên thực hiện</label>
                    <select class="form-select" aria-label="" name="manv" id="nhanvienthuchien">                
                        <?php foreach($nhanvienPB as $nhanvienTask) {?>
                            <?php if($nhanvienTask-> manv != $nhanvien['manv']){?>
                                <option value="<?=$nhanvienTask->manv?>"><?=$nhanvienTask -> ten?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div >
                <div class="mb-3">
                    <label class="form-label">Ngày hết hạn nhiệm vụ (deadline)</label>
                    <input type="date" id="ngayhethan" class="form-control" min="<?=date("Y-m-d")?>" name="deadline" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả nhiệm vụ</label>
                    <textarea class="form-control" id="motanhiemvu" name="mota" rows="4" required></textarea>
                </div>
                <div id="errortaotask" class="mb-3  mt-2 text-danger p-2"></div>
            </div>
            <div class="modal-footer">      
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit"  id="btn-taoTask" class="btn btn-primary">Lưu</button>
            </div>

          </form>
        </div>
      </div>
    </div>
    

    <script src="../main.js"></script>
</body>