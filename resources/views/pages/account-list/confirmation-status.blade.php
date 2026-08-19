<!-- Modal Konfirmasi Aktifkan/Non-Aktifkan Akun -->
<div class="modal fade" id="confirmationStatus" tabindex="-1" aria-labelledby="confirmationStatusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="statusForm" action="" method="post">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationStatusLabel">Konfirmasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="confirmationStatusMessage">Apakah Anda yakin?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" id="confirmationStatusSubmit" class="btn btn-primary">Ya, Lanjutkan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusModal = document.getElementById('confirmationStatus');

        $(statusModal).on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const userId = button.data('id');
            const action = button.data('action'); // "activate" atau "deactivate"
            const userName = button.data('name');

            const form = document.getElementById('statusForm');
            const messageEl = document.getElementById('confirmationStatusMessage');
            const submitBtn = document.getElementById('confirmationStatusSubmit');

            if (action === 'activate') {
                form.action = '/account-list/' + userId + '/activate';
                messageEl.textContent = 'Aktifkan akun "' + userName + '"?';
                submitBtn.textContent = 'Ya, Aktifkan';
                submitBtn.className = 'btn btn-success';
            } else if (action === 'deactivate') {
                form.action = '/account-list/' + userId + '/deactivate';
                messageEl.textContent = 'Non-Aktifkan akun "' + userName + '"?';
                submitBtn.textContent = 'Ya, Non-Aktifkan';
                submitBtn.className = 'btn btn-danger';
            }
        });
    });
</script>
@endpush