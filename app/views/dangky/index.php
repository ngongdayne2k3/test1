<?php include 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Đăng Kí Học Phần</h2>
    
    <?php if(isset($data['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo $data['error_message']; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($data['success_message'])): ?>
        <div class="alert alert-success">
            <?php echo $data['success_message']; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($data['danhSachDangKy'])): ?>
        <div class="alert alert-info">
            Tổng số tín chỉ đã đăng ký: <strong><?php echo $data['tongTinChi']; ?></strong>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số tín chỉ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['danhSachDangKy'] as $hocPhan): ?>
                    <tr>
                        <td><?php echo $hocPhan['mahp']; ?></td>
                        <td><?php echo $hocPhan['tenhp']; ?></td>
                        <td><?php echo $hocPhan['sotinchi']; ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>dangky/xoaHocPhan/<?php echo $hocPhan['mahp']; ?>" 
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
            <a href="<?php echo BASE_URL; ?>dangky/xoaTatCa" 
               class="btn btn-danger"
               onclick="return confirm('Bạn có chắc muốn xóa tất cả học phần?');">
                Xóa tất cả đăng ký
            </a>
            <a href="<?php echo BASE_URL; ?>dangky/luuDangKy" 
               class="btn btn-success"
               onclick="return confirm('Bạn có chắc muốn lưu đăng ký học phần?');">
                Lưu đăng ký
            </a>
            <a href="<?php echo BASE_URL; ?>hocphan" class="btn btn-primary">
                Đăng ký thêm học phần
            </a>
        </div>

        <?php if(isset($data['thongtin_dangky'])): ?>
            <div class="mt-4">
                <h3>Thông Tin Học Phần Đã Lưu</h3>
                <div class="card">
                    <div class="card-body">
                        <h5>Thông tin đăng ký:</h5>
                        <p>Mã số sinh viên: <?php echo $data['thongtin_dangky']['dangky']['masv']; ?></p>
                        <p>Ngày đăng ký: <?php echo date('d/m/Y H:i:s', strtotime($data['thongtin_dangky']['dangky']['ngaydk'])); ?></p>
                        <p>Mã đăng ký: <?php echo $data['thongtin_dangky']['dangky']['madk']; ?></p>

                        <h5 class="mt-3">Chi tiết học phần:</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã HP</th>
                                    <th>Tên học phần</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['thongtin_dangky']['chitiet'] as $index => $hp): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $hp['mahp']; ?></td>
                                        <td><?php echo $hp['tenhp']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

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