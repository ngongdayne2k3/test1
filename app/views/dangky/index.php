<?php include 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Đăng Kí Học Phần</h2>
    
    <?php if(isset($data['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $data['error_message']; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($data['danhSachDangKy'])): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['danhSachDangKy'] as $hocPhan): ?>
                    <tr>
                        <td><?php echo $hocPhan['mahp']; ?></td>
                        <td><?php echo $hocPhan['tenhp']; ?></td>
                        <td><?php echo $hocPhan['sotc']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>dangki/xoaHocPhan/<?php echo $hocPhan['mahp']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Bạn có chắc muốn xóa học phần này?');">
                                Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <a href="<?php echo BASE_URL; ?>dangki/xoaTatCa" 
               class="btn btn-danger"
               onclick="return confirm('Bạn có chắc muốn xóa tất cả học phần?');">
                Xóa tất cả đăng ký
            </a>
            <a href="<?php echo BASE_URL; ?>hocphan" class="btn btn-primary">
                Lưu đăng ký
            </a>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Bạn chưa đăng ký học phần nào.
        </div>
        <a href="<?php echo BASE_URL; ?>hocphan" class="btn btn-primary">
            Đăng ký học phần mới
        </a>
    <?php endif; ?>
</div>

<?php include 'app/views/layouts/footer.php'; ?> 