<?php
require_once 'app/config/config.php';
require_once 'app/models/SinhvienModel.php';

class SinhvienController {
    private $sinhvienModel;

    public function __construct() {
        $this->sinhvienModel = new SinhvienModel();
    }

    public function index() {
        try {
            $data = [
                'page_title' => 'Danh sách sinh viên',
                'sinhvien' => $this->sinhvienModel->getAllSinhVien()
            ];
            include 'app/views/sinhvien/index.php';
        } catch (Exception $e) {
            error_log("Error in index: " . $e->getMessage());
            die('Có lỗi xảy ra khi tải dữ liệu sinh viên');
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $hinh = '';
                if(isset($_FILES['hinh']) && $_FILES['hinh']['error'] === 0) {
                    $target_dir = "public/uploads/";
                    if (!file_exists($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    $hinh = time() . '_' . basename($_FILES["hinh"]["name"]);
                    move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_dir . $hinh);
                }

                $data = [
                    'masv' => $_POST['masv'],
                    'hoten' => $_POST['hoten'],
                    'gioitinh' => $_POST['gioitinh'],
                    'ngaysinh' => $_POST['ngaysinh'],
                    'hinh' => $hinh,
                    'manganh' => $_POST['manganh']
                ];

                if ($this->sinhvienModel->createSinhVien($data)) {
                    header('Location: ' . BASE_URL . 'sinhvien');
                    exit;
                } else {
                    throw new Exception("Không thể thêm sinh viên");
                }
            } catch (Exception $e) {
                error_log("Error in create: " . $e->getMessage());
                die('Có lỗi xảy ra khi thêm sinh viên');
            }
        }

        $data = [
            'page_title' => 'Thêm sinh viên mới',
            'nganh' => $this->sinhvienModel->getAllNganh()
        ];
        include 'app/views/sinhvien/create.php';
    }

    public function edit($masv) {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $hinh = $_POST['hinh_cu'];
                if(isset($_FILES['hinh']) && $_FILES['hinh']['error'] === 0) {
                    $target_dir = "public/uploads/";
                    if($hinh && file_exists($target_dir . $hinh)) {
                        unlink($target_dir . $hinh);
                    }
                    $hinh = time() . '_' . basename($_FILES["hinh"]["name"]);
                    move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_dir . $hinh);
                }

                $data = [
                    'hoten' => $_POST['hoten'],
                    'gioitinh' => $_POST['gioitinh'],
                    'ngaysinh' => $_POST['ngaysinh'],
                    'hinh' => $hinh,
                    'manganh' => $_POST['manganh']
                ];

                if ($this->sinhvienModel->updateSinhVien($masv, $data)) {
                    header('Location: ' . BASE_URL . 'sinhvien');
                    exit;
                } else {
                    throw new Exception("Không thể cập nhật sinh viên");
                }
            }

            $sinhvien = $this->sinhvienModel->getSinhVienById($masv);
            if (!$sinhvien) {
                die('Không tìm thấy sinh viên');
            }

            $data = [
                'page_title' => 'Chỉnh sửa sinh viên',
                'sinhvien' => $sinhvien,
                'nganh' => $this->sinhvienModel->getAllNganh(),
                'dangky' => $this->sinhvienModel->getDangKyBySinhVien($masv)
            ];

            include 'app/views/sinhvien/edit.php';
        } catch (Exception $e) {
            error_log("Error in edit: " . $e->getMessage());
            die('Có lỗi xảy ra khi cập nhật sinh viên');
        }
    }

    public function delete($masv) {
        try {
            $sinhvien = $this->sinhvienModel->getSinhVienById($masv);
            if($sinhvien && $sinhvien['hinh']) {
                $target_dir = "public/uploads/";
                $hinh_path = $target_dir . $sinhvien['hinh'];
                if(file_exists($hinh_path)) {
                    unlink($hinh_path);
                }
            }
            
            if ($this->sinhvienModel->deleteSinhVien($masv)) {
                header('Location: ' . BASE_URL . 'sinhvien');
                exit;
            } else {
                throw new Exception("Không thể xóa sinh viên");
            }
        } catch (Exception $e) {
            error_log("Error in delete: " . $e->getMessage());
            die('Có lỗi xảy ra khi xóa sinh viên');
        }
    }

    public function detail($masv) {
        try {
            $sinhvien = $this->sinhvienModel->getSinhVienById($masv);
            if (!$sinhvien) {
                die('Không tìm thấy sinh viên');
            }

            $data = [
                'page_title' => 'Chi tiết sinh viên',
                'sinhvien' => $sinhvien,
                'dangky' => $this->sinhvienModel->getDangKyBySinhVien($masv)
            ];

            include 'app/views/sinhvien/detail.php';
        } catch (Exception $e) {
            error_log("Error in detail: " . $e->getMessage());
            die('Có lỗi xảy ra khi xem chi tiết sinh viên');
        }
    }
}

