<?php
require_once 'app/config/config.php';

class HocPhanModel {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllHocPhan() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM hocphan");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllHocPhan: " . $e->getMessage());
            return [];
        }
    }

    public function dangKyHocPhan($masv, $mahp) {
        try {
            $this->db->beginTransaction();

            // Tạo đăng ký mới
            $stmt = $this->db->prepare("INSERT INTO dangky (masv, ngaydk) VALUES (:masv, NOW())");
            $stmt->bindParam(':masv', $masv);
            $stmt->execute();
            
            // Lấy ID đăng ký vừa tạo
            $madk = $this->db->lastInsertId();
            
            // Thêm chi tiết đăng ký
            $stmt = $this->db->prepare("INSERT INTO chitietdangky (madk, mahp) VALUES (:madk, :mahp)");
            $stmt->bindParam(':madk', $madk);
            $stmt->bindParam(':mahp', $mahp);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error in dangKyHocPhan: " . $e->getMessage());
            return false;
        }
    }
} 