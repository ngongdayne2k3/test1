<?php
require_once 'app/config/config.php';
require_once 'app/models/HocPhanModel.php';
require_once 'app/models/DangKyModel.php';

class HocPhanController {
    private $hocPhanModel;
    private $dangKyModel;

    public function __construct() {
        $this->hocPhanModel = new HocPhanModel();
        $this->dangKyModel = new DangKyModel();
        session_start();
        
        // Kiểm tra đăng nhập
        if(!isset($_SESSION['masv'])) {
            header('Location: ' . BASE_URL . 'dangnhap');
            exit;
        }
    }

    public function index() {
        $danhSachHocPhan = $this->hocPhanModel->getAllHocPhan();
        $data = [
            'page_title' => 'Danh sách học phần',
            'danhSachHocPhan' => $danhSachHocPhan
        ];
        include 'app/views/hocphan/index.php';
    }

    public function dangky($mahp = null) {
        if($mahp) {
            $masv = $_SESSION['masv'];
            if($this->dangKyModel->dangKyHocPhan($masv, $mahp)) {
                header('Location: ' . BASE_URL . 'dangky');
            } else {
                $_SESSION['error'] = 'Không thể đăng ký học phần này. Có thể học phần đã được đăng ký.';
                header('Location: ' . BASE_URL . 'hocphan');
            }
            exit;
        }
        header('Location: ' . BASE_URL . 'hocphan');
        exit;
    }
} 