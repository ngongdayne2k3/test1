<?php
require_once 'app/config/database.php';

class DangKyModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getDanhSachDangKy($masv) {
        $sql = "SELECT ctdk.mahp, hp.tenhp, hp.sotc
                FROM dangky dk 
                JOIN chitietdangky ctdk ON dk.madk = ctdk.madk
                JOIN hocphan hp ON ctdk.mahp = hp.mahp 
                WHERE dk.masv = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$masv]);
        return $stmt->fetchAll();
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