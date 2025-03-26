<?php include 'app/views/layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Đăng nhập</h2>
            </div>
            <div class="card-body">
                <?php if(isset($data['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $data['error_message']; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>dangnhap/login" method="POST">
                    <div class="mb-3">
                        <label for="masv" class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control" id="masv" name="masv" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?> 