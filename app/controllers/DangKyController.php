<?php
require_once 'app/config/config.php';
require_once 'app/models/DangKyModel.php';

class DangKyController {
    private $dangKyModel;

    public function __construct() {
        $this->dangKyModel = new DangKyModel();
        session_start();
        
        // Kiểm tra đăng nhập
        if(!isset($_SESSION['masv'])) {
            header('Location: ' . BASE_URL . 'dangnhap');
            exit;
        }
    }

    public function index() {
        $masv = $_SESSION['masv'];
        $danhSachDangKy = $this->dangKyModel->getDanhSachDangKy($masv);
        
        $data = [
            'page_title' => 'Danh sách học phần đã đăng ký',
            'danhSachDangKy' => $danhSachDangKy
        ];
        include 'app/views/dangky/index.php';
    }

    public function xoaHocPhan($mahp = null) {
        if($mahp) {
            $masv = $_SESSION['masv'];
            if($this->dangKyModel->xoaHocPhan($masv, $mahp)) {
                header('Location: ' . BASE_URL . 'dangky');
            } else {
                $data = [
                    'error_message' => 'Không thể xóa học phần'
                ];
                include 'app/views/dangky/index.php';
            }
        }
    }

    public function xoaTatCa() {
        $masv = $_SESSION['masv'];
        if($this->dangKyModel->xoaTatCaHocPhan($masv)) {
            header('Location: ' . BASE_URL . 'dangky');
        } else {
            $data = [
                'error_message' => 'Không thể xóa tất cả học phần'
            ];
            include 'app/views/dangky/index.php';
        }
    }
} 