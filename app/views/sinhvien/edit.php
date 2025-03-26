<?php include 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Chỉnh sửa thông tin sinh viên</h2>
    <form action="<?php echo BASE_URL; ?>sinhvien/edit/<?php echo $data['sinhvien']['masv']; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="masv" class="form-label">Mã sinh viên</label>
            <input type="text" class="form-control" id="masv" value="<?php echo $data['sinhvien']['masv']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="hoten" class="form-label">Họ tên</label>
            <input type="text" class="form-control" id="hoten" name="hoten" value="<?php echo $data['sinhvien']['hoten']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="gioitinh" class="form-label">Giới tính</label>
            <select class="form-control" id="gioitinh" name="gioitinh" required>
                <option value="Nam" <?php echo ($data['sinhvien']['gioitinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?php echo ($data['sinhvien']['gioitinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="ngaysinh" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="<?php echo $data['sinhvien']['ngaysinh']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="hinh" class="form-label">Hình ảnh</label>
            <?php if($data['sinhvien']['hinh']): ?>
                <div class="mb-2">
                    <img src="<?php echo BASE_URL; ?>public/uploads/<?php echo $data['sinhvien']['hinh']; ?>" alt="Hình sinh viên" style="max-width: 200px;">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*">
            <input type="hidden" name="hinh_cu" value="<?php echo $data['sinhvien']['hinh']; ?>">
        </div>
        <div class="mb-3">
            <label for="manganh" class="form-label">Ngành học</label>
            <select class="form-control" id="manganh" name="manganh" required>
                <option value="">Chọn ngành</option>
                <?php foreach ($data['nganh'] as $nganh): ?>
                    <option value="<?php echo $nganh['manganh']; ?>" <?php echo ($data['sinhvien']['manganh'] == $nganh['manganh']) ? 'selected' : ''; ?>>
                        <?php echo $nganh['tennganh']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="<?php echo BASE_URL; ?>sinhvien" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<?php include 'app/views/layouts/footer.php'; ?> 