


<div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
    <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
            <ul class="navbar-nav ">
                <li>
                    <div class="text-muted small mt-2 fw-bold text-uppercase px-3">
                        Nhân viên
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
                    <a href="task.php" class="nav-link nav-link-custom px-3 ">
                    <i class="fas fa-tasks"></i>  <span>Nhiệm vụ(task)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="nghiphep.php" class="nav-link nav-link-custom px-3 ">
                    <i class="far fa-calendar-alt"></i>    <span>Nghỉ phép</span>
                    </a>
                </li>
                
                <li class="my-4">
                    <hr class="dropdown-divider bg-light" />
                </li>
            </ul>
        </nav>
    </div>
</div>
