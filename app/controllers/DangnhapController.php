<?php
require_once 'app/config/config.php';
require_once 'app/models/AuthModel.php';

class DangNhapController {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
        session_start();
    }

    public function index() {
        // Nếu đã đăng nhập thì chuyển về trang chủ
        if(isset($_SESSION['masv'])) {
            header('Location: ' . BASE_URL . 'hocphan');
            exit;
        }
        
        $data = [
            'page_title' => 'Đăng nhập'
        ];
        include 'app/views/dangnhap/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $masv = $_POST['masv'];
            
            // Kiểm tra sinh viên tồn tại
            $sinhvien = $this->authModel->checkSinhVien($masv);
            
            if ($sinhvien) {
                // Lưu thông tin vào session
                $_SESSION['masv'] = $sinhvien['masv'];
                $_SESSION['hoten'] = $sinhvien['hoten'];
                
                header('Location: ' . BASE_URL . 'hocphan');
                exit;
            } else {
                $data = [
                    'page_title' => 'Đăng nhập',
                    'error_message' => 'Mã sinh viên không tồn tại'
                ];
                include 'app/views/dangnhap/login.php';
            }
        }
    }

    public function logout() {
        // Xóa session
        session_start();
        session_destroy();
        
        header('Location: ' . BASE_URL . 'dangnhap');
        exit;
    }
} 