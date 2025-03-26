<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #333 !important;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .nav-link:hover {
            color: #ddd !important;
        }
        .active {
            font-weight: bold;
        }
        .welcome-text {
            color: #fff;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <?php
    if(isset($_SESSION['masv'])) {
        require_once 'app/models/DangKyModel.php';
        $dangKyModel = new DangKyModel();
        $soHocPhan = $dangKyModel->getSoHocPhanDaDangKy($_SESSION['masv']);
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">Test1</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == BASE_URL.'sinhvien') ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>sinhvien">Sinh Viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == BASE_URL.'hocphan') ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>hocphan">Học Phần</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == BASE_URL.'dangky') ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>dangky">Đăng Ký (<?php echo isset($soHocPhan) ? $soHocPhan : 0; ?>)</a>
                    </li>
                </ul>
                <?php if(isset($_SESSION['masv'])): ?>
                    <span class="welcome-text">Xin chào, <?php echo $_SESSION['hoten']; ?></span>
                    <a href="<?php echo BASE_URL; ?>dangnhap/logout" class="btn btn-outline-light">Đăng xuất</a>
                <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>dangnhap" class="btn btn-outline-light">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container"><?php if(isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?> 