<?php
require_once 'app/config/database.php';

class DangKyModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getDanhSachDangKy($masv) {
        $sql = "SELECT ctdk.mahp, hp.tenhp, hp.sotinchi
                FROM dangky dk 
                JOIN chitietdangky ctdk ON dk.madk = ctdk.madk
                JOIN hocphan hp ON ctdk.mahp = hp.mahp 
                WHERE dk.masv = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$masv]);
        return $stmt->fetchAll();
    }

    public function getTongTinChi($masv) {
        $sql = "SELECT SUM(hp.sotinchi) as tongtc
                FROM dangky dk 
                JOIN chitietdangky ctdk ON dk.madk = ctdk.madk
                JOIN hocphan hp ON ctdk.mahp = hp.mahp 
                WHERE dk.masv = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$masv]);
        $result = $stmt->fetch();
        return $result['tongtc'] ?? 0;
    }

    public function getSoHocPhanDaDangKy($masv) {
        $sql = "SELECT COUNT(ctdk.mahp) as total
                FROM dangky dk 
                JOIN chitietdangky ctdk ON dk.madk = ctdk.madk
                WHERE dk.masv = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$masv]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    public function luuDangKy($masv) {
        try {
            $this->conn->beginTransaction();

            // Cập nhật ngày đăng ký
            $sql = "UPDATE dangky SET ngaydk = NOW() WHERE masv = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$masv]);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getThongTinDangKy($masv) {
        // Lấy thông tin từ bảng dangky
        $sql = "SELECT dk.madk, dk.ngaydk, dk.masv 
                FROM dangky dk 
                WHERE dk.masv = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$masv]);
        $dangky = $stmt->fetch();

        if (!$dangky) {
            return null;
        }

        // Lấy chi tiết học phần đã đăng ký
        $sql = "SELECT ctdk.madk, ctdk.mahp, hp.tenhp
                FROM chitietdangky ctdk
                JOIN hocphan hp ON ctdk.mahp = hp.mahp
                WHERE ctdk.madk = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$dangky['madk']]);
        $chitiet = $stmt->fetchAll();

        return [
            'dangky' => $dangky,
            'chitiet' => $chitiet
        ];
    }

    public function dangKyHocPhan($masv, $mahp) {
        try {
            // Kiểm tra xem sinh viên đã có bản ghi trong bảng dangky chưa
            $sql = "SELECT madk FROM dangky WHERE masv = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$masv]);
            $dangky = $stmt->fetch();

            // Nếu chưa có, tạo mới bản ghi trong bảng dangky
            if (!$dangky) {
                $sql = "INSERT INTO dangky (masv) VALUES (?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$masv]);
                $madk = $this->conn->lastInsertId();
            } else {
                $madk = $dangky['madk'];
            }

            // Kiểm tra xem học phần đã được đăng ký chưa
            $sql = "SELECT * FROM chitietdangky WHERE madk = ? AND mahp = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$madk, $mahp]);
            if ($stmt->fetch()) {
                return false; // Học phần đã được đăng ký
            }

            // Thêm chi tiết đăng ký
            $sql = "INSERT INTO chitietdangky (madk, mahp) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$madk, $mahp]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function xoaHocPhan($masv, $mahp) {
        $sql = "DELETE ctdk FROM chitietdangky ctdk 
                JOIN dangky dk ON ctdk.madk = dk.madk 
                WHERE dk.masv = ? AND ctdk.mahp = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$masv, $mahp]);
    }

    public function xoaTatCaHocPhan($masv) {
        $sql = "DELETE ctdk FROM chitietdangky ctdk 
                JOIN dangky dk ON ctdk.madk = dk.madk 
                WHERE dk.masv = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$masv]);
    }
} 