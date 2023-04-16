


<div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
    <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
            <ul class="navbar-nav ">
                <li>
                    <div class="text-muted small mt-2 fw-bold text-uppercase px-3">
                        Giám đốc
                    </div>
                </li>
                <li>
                    <a href="index.php" class="nav-link nav-link-custom px-3 active">
                        <span><?=$_SESSION['ten']?></span>
                    </a>
                </li>
                <li class="my-4">
                    <hr class="dropdown-divider bg-light" />
                </li>
                <li>
                    <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                        Chức năng
                    </div>
                </li>
                <li class="nav-item">
                    <a href="nhanvien.php" class="nav-link nav-link-custom px-3 ">
                    <i class='fas fa-address-card'></i>
                        <span>Quản lý nhân viên</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="phongban.php" class="nav-link nav-link-custom px-3 ">
                    <i class='far fa-building'></i>
                        <span>Quản lý phòng ban</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="duyet-don-nghi-phep.php" class="nav-link nav-link-custom px-3 ">
                        <i class="far fa-calendar-alt"></i>    
                        <span>Duyệt đơn nghỉ phép</span>
                    </a>
                </li>
                <li class="my-4">
                    <hr class="dropdown-divider bg-light" />
                </li>
            </ul>
        </nav>
    </div>
</div>
