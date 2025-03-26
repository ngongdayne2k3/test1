<?php include 'app/views/layouts/header.php'; ?>


<h2>Thêm sinh viên mới</h2>
<form action="<?php echo BASE_URL; ?>sinhvien/create" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="masv" class="form-label">Mã sinh viên</label>
        <input type="text" class="form-control" id="masv" name="masv" required>
    </div>
    <div class="mb-3">
        <label for="hoten" class="form-label">Họ tên</label>
        <input type="text" class="form-control" id="hoten" name="hoten" required>
    </div>
    <div class="mb-3">
        <label for="gioitinh" class="form-label">Giới tính</label>
        <select class="form-control" id="gioitinh" name="gioitinh" required>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="ngaysinh" class="form-label">Ngày sinh</label>
        <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required>
    </div>
    <div class="mb-3">
        <label for="hinh" class="form-label">Hình ảnh</label>
        <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*">
    </div>
    <div class="mb-3">
        <label for="manganh" class="form-label">Ngành học</label>
        <select class="form-control" id="manganh" name="manganh" required>
            <option value="">Chọn ngành</option>
            <?php foreach ($data['nganh'] as $ng): ?>
                <option value="<?php echo $ng['manganh']; ?>"><?php echo $ng['tennganh']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Thêm mới</button>
    <a href="<?php echo BASE_URL; ?>sinhvien" class="btn btn-secondary">Quay lại</a>
</form>

<?php include 'app/views/layouts/footer.php'; ?> 