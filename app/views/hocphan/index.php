<?php include 'app/views/layouts/header.php'; ?>

<h2>Danh sách học phần</h2>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã học phần</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['hocphan'] as $hp): ?>
            <tr>
                <td><?php echo htmlspecialchars($hp['mahp']); ?></td>
                <td><?php echo htmlspecialchars($hp['tenhp']); ?></td>
                <td><?php echo htmlspecialchars($hp['sotinchi']); ?></td>
                <td>
                    <button type="button" 
                            class="btn btn-success btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#dangkyModal" 
                            data-mahp="<?php echo htmlspecialchars($hp['mahp']); ?>"
                            data-tenhp="<?php echo htmlspecialchars($hp['tenhp']); ?>">
                        Đăng ký
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Đăng ký -->
<div class="modal fade" id="dangkyModal" tabindex="-1" aria-labelledby="dangkyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dangkyModalLabel">Đăng ký học phần</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>hocphan/dangky" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="masv" class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control" id="masv" name="masv" required>
                    </div>
                    <input type="hidden" id="mahp" name="mahp">
                    <p>Bạn có chắc muốn đăng ký học phần <span id="tenhp_display"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var dangkyModal = document.getElementById('dangkyModal');
    dangkyModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var mahp = button.getAttribute('data-mahp');
        var tenhp = button.getAttribute('data-tenhp');
        
        var modal = this;
        modal.querySelector('#mahp').value = mahp;
        modal.querySelector('#tenhp_display').textContent = tenhp;
    });
});
</script>

<?php include 'app/views/layouts/footer.php'; ?> 