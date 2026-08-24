<div class="modal fade" id="linkResidentModal" tabindex="-1" aria-labelledby="linkResidentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="linkResidentForm" action="" method="post">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="linkResidentModalLabel">Edit Keterkaitan Akun</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Akun: <strong id="linkResidentUserName"></strong></p>
                    <div class="form-group">
                        <label for="link_resident_id">Pilih Data Penduduk</label>
                        <select name="resident_id" id="link_resident_id" class="form-control">
                            <option value="">Tidak ada</option>
                            @foreach ($residents as $resident)
                                <option value="{{ $resident->id }}">{{ $resident->name }} - {{ $resident->nik }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#linkResidentModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const userId = button.data('id');
            const userName = button.data('name');
            const residentId = String(button.data('resident-id') || '');

            const form = document.getElementById('linkResidentForm');
            form.action = '/account-list/' + userId + '/link-resident';
            document.getElementById('linkResidentUserName').textContent = userName;
            document.getElementById('link_resident_id').value = residentId;
        });
    });
</script>
@endpush