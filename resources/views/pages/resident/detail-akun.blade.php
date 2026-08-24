<div class="modal fade" id="detailAkunModal" tabindex="-1" aria-labelledby="detailAkunModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailAkunModalLabel">Detail Akun</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="detail_akun_name">Nama</label>
                    <input type="text" id="detail_akun_name" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="detail_akun_email">Email</label>
                    <input type="text" id="detail_akun_email" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#detailAkunModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            document.getElementById('detail_akun_name').value = button.data('name');
            document.getElementById('detail_akun_email').value = button.data('email');
        });
    });
</script>
@endpush