<?php
require_once 'app/config/config.php';
require_once 'app/models/HocPhanModel.php';

class HocPhanController {
    private $hocPhanModel;

    public function __construct() {
        session_start();
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['masv'])) {
            header('Location: ' . BASE_URL . 'dangnhap');
            exit;
        }
        $this->hocPhanModel = new HocPhanModel();
    }

    public function index() {
        try {
            $data = [
                'page_title' => 'Danh sách học phần',
                'hocphan' => $this->hocPhanModel->getAllHocPhan()
            ];
            include 'app/views/hocphan/index.php';
        } catch (Exception $e) {
            error_log("Error in index: " . $e->getMessage());
            die('Có lỗi xảy ra khi tải danh sách học phần');
        }
    }

    public function dangky() {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $masv = $_SESSION['masv']; // Lấy mã sinh viên từ session
                $mahp = $_POST['mahp'];
                
                if ($this->hocPhanModel->dangKyHocPhan($masv, $mahp)) {
                    header('Location: ' . BASE_URL . 'hocphan');
                    exit;
                } else {
                    throw new Exception("Không thể đăng ký học phần");
                }
            }
        } catch (Exception $e) {
            error_log("Error in dangky: " . $e->getMessage());
            die('Có lỗi xảy ra khi đăng ký học phần');
        }
    }
} 