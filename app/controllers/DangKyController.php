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
        $tongTinChi = $this->dangKyModel->getTongTinChi($masv);
        
        $data = [
            'page_title' => 'Danh sách học phần đã đăng ký',
            'danhSachDangKy' => $danhSachDangKy,
            'tongTinChi' => $tongTinChi
        ];

        // Nếu có thông báo thành công
        if(isset($_SESSION['success_message'])) {
            $data['success_message'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }

        // Nếu có thông tin đăng ký đã lưu
        if(isset($_SESSION['thongtin_dangky'])) {
            $data['thongtin_dangky'] = $_SESSION['thongtin_dangky'];
            unset($_SESSION['thongtin_dangky']);
        }

        include 'app/views/dangky/index.php';
    }

    public function luuDangKy() {
        $masv = $_SESSION['masv'];
        
        if($this->dangKyModel->luuDangKy($masv)) {
            // Lấy thông tin đăng ký để hiển thị
            $thongTinDangKy = $this->dangKyModel->getThongTinDangKy($masv);
            
            $_SESSION['success_message'] = 'Đăng ký học phần thành công!';
            $_SESSION['thongtin_dangky'] = $thongTinDangKy;
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi lưu đăng ký!';
        }
        
        header('Location: ' . BASE_URL . 'dangky');
        exit;
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