<?php include 'app/views/layouts/header.php'; ?>

<h2>Chi tiết sinh viên</h2>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <?php if($sinhvien['hinh']): ?>
                    <img src="<?php echo BASE_URL; ?>public/uploads/<?php echo $sinhvien['hinh']; ?>" 
                         alt="Hình sinh viên" class="img-fluid rounded">
                <?php else: ?>
                    <div class="alert alert-info">Không có hình ảnh</div>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <h5 class="card-title"><?php echo $sinhvien['hoten']; ?></h5>
                <p class="card-text">
                    <strong>Mã sinh viên:</strong> <?php echo $sinhvien['masv']; ?><br>
                    <strong>Ngày sinh:</strong> <?php echo date('d/m/Y', strtotime($sinhvien['ngaysinh'])); ?><br>
                    <strong>Giới tính:</strong> <?php echo $sinhvien['gioitinh']; ?><br>
                    <strong>Ngành học:</strong> <?php echo $sinhvien['tennganh']; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="mt-3">
    <a href="<?php echo BASE_URL; ?>sinhvien/edit/<?php echo $sinhvien['masv']; ?>" class="btn btn-warning">Chỉnh sửa</a>
    <a href="<?php echo BASE_URL; ?>sinhvien" class="btn btn-secondary">Quay lại</a>
    <a href="<?php echo BASE_URL; ?>sinhvien/delete/<?php echo $sinhvien['masv']; ?>" 
       class="btn btn-danger" 
       onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">Xóa</a>
</div>

<?php include 'app/views/layouts/footer.php'; ?> 