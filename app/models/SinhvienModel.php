<?php
require_once 'app/config/config.php';

class SinhvienModel {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllSinhVien() {
        try {
            $stmt = $this->db->prepare("
                SELECT sv.*, nh.tennganh 
                FROM sinhvien sv 
                LEFT JOIN nganhhoc nh ON sv.manganh = nh.manganh
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllSinhVien: " . $e->getMessage());
            return [];
        }
    }

    public function getSinhVienById($masv) {
        try {
            $stmt = $this->db->prepare("
                SELECT sv.*, nh.tennganh 
                FROM sinhvien sv 
                LEFT JOIN nganhhoc nh ON sv.manganh = nh.manganh 
                WHERE sv.masv = :masv
            ");
            $stmt->bindParam(':masv', $masv);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getSinhVienById: " . $e->getMessage());
            return null;
        }
    }

    public function createSinhVien($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO sinhvien (masv, hoten, gioitinh, ngaysinh, hinh, manganh) 
                VALUES (:masv, :hoten, :gioitinh, :ngaysinh, :hinh, :manganh)
            ");
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Error in createSinhVien: " . $e->getMessage());
            return false;
        }
    }

    public function updateSinhVien($masv, $data) {
        try {
            $stmt = $this->db->prepare("
                UPDATE sinhvien 
                SET hoten = :hoten, 
                    gioitinh = :gioitinh, 
                    ngaysinh = :ngaysinh,
                    hinh = :hinh,
                    manganh = :manganh 
                WHERE masv = :masv
            ");
            $data['masv'] = $masv;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Error in updateSinhVien: " . $e->getMessage());
            return false;
        }
    }

    public function deleteSinhVien($masv) {
        try {
            // Xóa các bản ghi liên quan trong bảng dangky trước
            $stmt = $this->db->prepare("
                DELETE FROM chitietdangky 
                WHERE madk IN (SELECT madk FROM dangky WHERE masv = :masv)
            ");
            $stmt->bindParam(':masv', $masv);
            $stmt->execute();

            // Xóa các bản ghi trong bảng dangky
            $stmt = $this->db->prepare("DELETE FROM dangky WHERE masv = :masv");
            $stmt->bindParam(':masv', $masv);
            $stmt->execute();

            // Sau đó mới xóa sinh viên
            $stmt = $this->db->prepare("DELETE FROM sinhvien WHERE masv = :masv");
            $stmt->bindParam(':masv', $masv);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in deleteSinhVien: " . $e->getMessage());
            return false;
        }
    }

    public function getAllNganh() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM nganhhoc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllNganh: " . $e->getMessage());
            return [];
        }
    }

    public function getDangKyBySinhVien($masv) {
        try {
            $stmt = $this->db->prepare("
                SELECT dk.madk, dk.ngaydk, hp.mahp, hp.tenhp, hp.sotinchi
                FROM dangky dk
                JOIN chitietdangky ctdk ON dk.madk = ctdk.madk
                JOIN hocphan hp ON ctdk.mahp = hp.mahp
                WHERE dk.masv = :masv
            ");
            $stmt->bindParam(':masv', $masv);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getDangKyBySinhVien: " . $e->getMessage());
            return [];
        }
    }
}
