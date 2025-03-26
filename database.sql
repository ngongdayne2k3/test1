-- Xóa database nếu tồn tại
DROP DATABASE IF EXISTS test1;

-- Tạo database mới
CREATE DATABASE test1;
USE test1;

-- Tạo bảng ngành học
CREATE TABLE nganhhoc (
    manganh CHAR(4) PRIMARY KEY,
    tennganh VARCHAR(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng sinh viên
CREATE TABLE sinhvien (
    masv CHAR(10) PRIMARY KEY,
    hoten VARCHAR(50) NOT NULL,
    gioitinh VARCHAR(5),
    ngaysinh DATE,
    hinh VARCHAR(50),
    manganh CHAR(4),
    FOREIGN KEY (manganh) REFERENCES nganhhoc(manganh)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng học phần
CREATE TABLE hocphan (
    mahp CHAR(6) PRIMARY KEY,
    tenhp VARCHAR(30) NOT NULL,
    sotinchi INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng đăng ký
CREATE TABLE dangky (
    madk INT AUTO_INCREMENT PRIMARY KEY,
    ngaydk DATE,
    masv CHAR(10),
    FOREIGN KEY (masv) REFERENCES sinhvien(masv)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng chi tiết đăng ký
CREATE TABLE chitietdangky (
    madk INT,
    mahp CHAR(6),
    PRIMARY KEY (madk, mahp),
    FOREIGN KEY (madk) REFERENCES dangky(madk),
    FOREIGN KEY (mahp) REFERENCES hocphan(mahp)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu cho bảng ngành học
INSERT INTO nganhhoc(manganh, tennganh) VALUES
('CNTT', 'Công nghệ thông tin'),
('QTKD', 'Quản trị kinh doanh');

-- Thêm dữ liệu mẫu cho bảng sinh viên
INSERT INTO sinhvien(masv, hoten, gioitinh, ngaysinh, hinh, manganh) VALUES
('N21DCCN01', 'Nguyễn Văn A', 'Nam', '2000-12-02', '/content/images/sv1.jpg', 'CNTT'),
('N21DCCN02', 'Trần Thị B', 'Nữ', '2000-06-05', '/content/images/sv2.jpg', 'QTKD');

-- Thêm dữ liệu mẫu cho bảng học phần
INSERT INTO hocphan(mahp, tenhp, sotinchi) VALUES
('CNTT01', 'Lập trình C', 3),
('CNTT02', 'Cơ sở dữ liệu', 2),
('QTDM01', 'Kinh tế vi mô', 2),
('QTDM02', 'Xác suất thống kê 1', 3);

-- Kiểm tra dữ liệu
SELECT * FROM nganhhoc;
SELECT * FROM sinhvien;
SELECT * FROM hocphan;
SELECT * FROM dangky;
SELECT * FROM chitietdangky; 