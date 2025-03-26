<?php include 'app/views/layouts/header.php'; ?>

<h2>Danh sách sinh viên</h2>
<a href="<?php echo BASE_URL; ?>sinhvien/create" class="btn btn-primary mb-3">Thêm sinh viên mới</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Mã SV</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Hình</th>
            <th>Ngành</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['sinhvien'] as $sv): ?>
        <tr>
            <td><?php echo $sv['masv']; ?></td>
            <td><?php echo $sv['hoten']; ?></td>
            <td><?php echo $sv['gioitinh']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($sv['ngaysinh'])); ?></td>
            <td>
                <?php if($sv['hinh']): ?>
                    <img src="<?php echo BASE_URL; ?>public/uploads/<?php echo $sv['hinh']; ?>" 
                         alt="Hình sinh viên" style="max-width: 50px;">
                <?php endif; ?>
            </td>
            <td><?php echo $sv['tennganh']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>sinhvien/detail/<?php echo $sv['masv']; ?>" 
                   class="btn btn-info btn-sm">Chi tiết</a>
                <a href="<?php echo BASE_URL; ?>sinhvien/edit/<?php echo $sv['masv']; ?>" 
                   class="btn btn-warning btn-sm">Sửa</a>
                <a href="<?php echo BASE_URL; ?>sinhvien/delete/<?php echo $sv['masv']; ?>" 
                   class="btn btn-danger btn-sm" 
                   onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'app/views/layouts/footer.php'; ?> 