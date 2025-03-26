<?php
require_once 'app/config/config.php';

class AuthModel {
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function checkSinhVien($masv) {
        try {
            $stmt = $this->db->prepare("SELECT masv, hoten FROM sinhvien WHERE masv = :masv");
            $stmt->bindParam(':masv', $masv);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : null;
        } catch (PDOException $e) {
            error_log("Error in checkSinhVien: " . $e->getMessage());
            return null;
        }
    }
} 