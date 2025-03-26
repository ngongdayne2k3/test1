<?php include 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Danh sách học phần</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã HP</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['danhSachHocPhan'] as $hocPhan): ?>
                <tr>
                    <td><?php echo $hocPhan['mahp']; ?></td>
                    <td><?php echo $hocPhan['tenhp']; ?></td>
                    <td><?php echo $hocPhan['sotinchi']; ?></td>
                    <td>
                        <a href="<?php echo BASE_URL; ?>hocphan/dangky/<?php echo $hocPhan['mahp']; ?>" 
                           class="btn btn-primary btn-sm"
                           onclick="return confirm('Bạn có chắc muốn đăng ký học phần này?');">
                            Đăng ký
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'app/views/layouts/footer.php'; ?> 