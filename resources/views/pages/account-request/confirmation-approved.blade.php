<!-- Modal Konfirmasi Approve/Reject (SATU untuk semua baris) -->
<div class="modal fade" id="confirmationAction" tabindex="-1" aria-labelledby="confirmationActionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="actionForm" action="" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationActionLabel">Konfirmasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="confirmationActionMessage">Apakah Anda yakin?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="confirmationActionSubmit" class="btn btn-primary">Ya, Lanjutkan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const actionModal = document.getElementById('confirmationAction');

        $(actionModal).on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const userId = button.data('id');
            const action = button.data('action'); // "approve" atau "reject"
            const userName = button.data('name');

            const form = document.getElementById('actionForm');
            const messageEl = document.getElementById('confirmationActionMessage');
            const submitBtn = document.getElementById('confirmationActionSubmit');

            if (action === 'approve') {
                form.action = '/account-request/' + userId + '/approve';
                messageEl.textContent = 'Setujui permintaan akun dari "' + userName + '"?';
                submitBtn.textContent = 'Ya, Setujui';
                submitBtn.className = 'btn btn-success';
            } else if (action === 'reject') {
                form.action = '/account-request/' + userId + '/reject';
                messageEl.textContent = 'Tolak permintaan akun dari "' + userName + '"?';
                submitBtn.textContent = 'Ya, Tolak';
                submitBtn.className = 'btn btn-danger';
            }
        });
    });
</script>
@endpush