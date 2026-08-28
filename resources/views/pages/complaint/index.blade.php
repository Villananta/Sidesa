@extends('layout.app')

@section('content')

    @php
        $isAdmin = auth()->user()->role->name === 'Admin';
    @endphp

    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "{{ session('error') }}",
                icon: "error"
            });
        </script>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $isAdmin ? 'Pengaduan Masyarakat' : 'Pengaduan Saya' }}</h1>
        @if (!$isAdmin && auth()->user()->resident)
            <button type="button" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#createComplaintModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Pengaduan
            </button>
        @endif
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">

                    @if (is_null($complaints))
                        <p class="text-center pt-3 text-muted">
                            Akun Anda belum terkait dengan data penduduk. Silakan hubungi admin untuk mengaitkan akun Anda terlebih dahulu.
                        </p>
                    @elseif ($isAdmin)
                        {{-- Tabel khusus Admin: semua pengaduan, read-only --}}
                        <table class="table table-bordered table-hovered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pengadu</th>
                                    <th>Judul</th>
                                    <th>Isi Pengaduan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Tanggapan</th>
                                    <th>Bukti Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            @if (count($complaints) < 1)
                                <tbody>
                                    <tr>
                                        <td colspan="9"><p class="text-center pt-3">Belum ada pengaduan.</p></td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    @foreach ($complaints as $complaint)
                                        <tr>
                                            <td>{{ $loop->iteration + $complaints->firstitem() - 1 }}</td>
                                            <td>{{ $complaint->resident->name ?? '-' }}</td>
                                            <td>{{ $complaint->title }}</td>
                                            <td>{{ $complaint->content }}</td>
                                            <td>{{ \Carbon\Carbon::parse($complaint->complaint_date)->format('d-m-Y') }}</td>
                                            <td>
                                                @if ($complaint->status == 'rejected')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @elseif ($complaint->status == 'confirmed')
                                                    <span class="badge badge-secondary">Diterima</span>
                                                @elseif ($complaint->status == 'processing')
                                                    <span class="badge badge-warning">Diproses</span>
                                                @else
                                                    <span class="badge badge-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>{{ $complaint->response ?? '-' }}</td>
                                            <td>
                                                @if ($complaint->photo_prove)
                                                    <a href="{{ asset('storage/' . $complaint->photo_prove) }}" target="_blank">Lihat Foto</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#manageComplaintModal"
                                                    data-id="{{ $complaint->id }}"
                                                    data-title="{{ $complaint->title }}"
                                                    data-status="{{ $complaint->status }}"
                                                    data-response="{{ $complaint->response }}">
                                                    <i class="fas fa-reply"></i> Kelola
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>

                        @if ($complaints->lastPage() > 1)
                            <div class="card-footer">
                                {{ $complaints->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    @else
                        {{-- Tabel khusus User: pengaduan miliknya sendiri, bisa edit/hapus --}}
                        <table class="table table-bordered table-hovered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Isi Pengaduan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Bukti Foto</th>
                                    <th>Tanggapan Admin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            @if (count($complaints) < 1)
                                <tbody>
                                    <tr>
                                        <td colspan="7"><p class="text-center pt-3">Belum ada pengaduan.</p></td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    @foreach ($complaints as $complaint)
                                        <tr>
                                            <td>{{ $loop->iteration + $complaints->firstitem() - 1 }}</td>
                                            <td>{{ $complaint->title }}</td>
                                            <td>{{ $complaint->content }}</td>
                                            <td>{{ \Carbon\Carbon::parse($complaint->complaint_date)->format('d-m-Y') }}</td>
                                            <td>
                                                @if ($complaint->status == 'rejected')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @elseif ($complaint->status == 'confirmed')
                                                    <span class="badge badge-secondary">Diterima</span>
                                                @elseif ($complaint->status == 'processing')
                                                    <span class="badge badge-warning">Diproses</span>
                                                @else
                                                    <span class="badge badge-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($complaint->photo_prove)
                                                    <a href="{{ asset('storage/' . $complaint->photo_prove) }}" target="_blank">Lihat Foto</a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $complaint->response ?? '-' }}</td>
                                            <td>
                                                @if ($complaint->status == 'confirmed')
                                                    <div class="d-flex">
                                                        <button type="button" class="btn btn-sm btn-warning mr-2"
                                                            data-toggle="modal"
                                                            data-target="#editComplaintModal"
                                                            data-id="{{ $complaint->id }}"
                                                            data-title="{{ $complaint->title }}"
                                                            data-content="{{ $complaint->content }}">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#deleteComplaintModal"
                                                            data-id="{{ $complaint->id }}"
                                                            data-title="{{ $complaint->title }}">
                                                            <i class="fas fa-eraser"></i>
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>

                        @if ($complaints->lastPage() > 1)
                            <div class="card-footer">
                                {{ $complaints->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

    @unless ($isAdmin)
        <!-- Modal Buat Pengaduan -->
        <div class="modal fade" id="createComplaintModal" tabindex="-1" aria-labelledby="createComplaintModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('complaint.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createComplaintModalLabel">Buat Pengaduan Baru</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="title">Judul</label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="content">Isi Pengaduan</label>
                                <textarea name="content" id="content" rows="4"
                                    class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="photo_prove">Bukti Foto (opsional)</label>
                                <input type="file" name="photo_prove" id="photo_prove"
                                    class="form-control @error('photo_prove') is-invalid @enderror" accept="image/*">
                                @error('photo_prove')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Pengaduan -->
        <div class="modal fade" id="editComplaintModal" tabindex="-1" aria-labelledby="editComplaintModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editComplaintForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editComplaintModalLabel">Edit Pengaduan</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="edit_title">Judul</label>
                                <input type="text" name="title" id="edit_title" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="edit_content">Isi Pengaduan</label>
                                <textarea name="content" id="edit_content" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="edit_photo_prove">Ganti Bukti Foto (opsional)</label>
                                <input type="file" name="photo_prove" id="edit_photo_prove" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Hapus Pengaduan -->
        <div class="modal fade" id="deleteComplaintModal" tabindex="-1" aria-labelledby="deleteComplaintModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="deleteComplaintForm" action="" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteComplaintModalLabel">Konfirmasi Hapus</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span id="deleteComplaintMessage">Apakah Anda yakin ingin menghapus pengaduan ini?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endunless

    @if ($isAdmin)
    <!-- Modal Kelola Pengaduan (Admin) -->
        <div class="modal fade" id="manageComplaintModal" tabindex="-1" aria-labelledby="manageComplaintModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="manageComplaintForm" action="" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="manageComplaintModalLabel">Kelola Pengaduan</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Judul: <strong id="manageComplaintTitle"></strong></p>
                            <div class="form-group mb-3">
                                <label for="manage_status">Status</label>
                                <select name="status" id="manage_status" class="form-control">
                                    <option value="rejected">Ditolak</option>
                                    <option value="confirmed">Diterima</option>
                                    <option value="processing">Diproses</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="manage_response">Tanggapan</label>
                                <textarea name="response" id="manage_response" rows="4" class="form-control"></textarea>
                                @error('response')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
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
    @endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('editComplaintModal');
        if (editModal) {
            $(editModal).on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const complaintId = button.data('id');
                const title = button.data('title');
                const content = button.data('content');

                const form = document.getElementById('editComplaintForm');
                form.action = '/complaint/' + complaintId;
                document.getElementById('edit_title').value = title;
                document.getElementById('edit_content').value = content;
            });
        }

        const deleteModal = document.getElementById('deleteComplaintModal');
        if (deleteModal) {
            $(deleteModal).on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const complaintId = button.data('id');
                const title = button.data('title');

                const form = document.getElementById('deleteComplaintForm');
                form.action = '/complaint/' + complaintId;
                document.getElementById('deleteComplaintMessage').textContent = 'Apakah Anda yakin ingin menghapus pengaduan "' + title + '"?';
            });
        }

        const manageModal = document.getElementById('manageComplaintModal');
        if (manageModal) {
        $(manageModal).on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const complaintId = button.data('id');
        const title = button.data('title');
        const status = button.data('status');
        const response = button.data('response');

        const form = document.getElementById('manageComplaintForm');
        form.action = '/complaint/' + complaintId + '/status';
        document.getElementById('manageComplaintTitle').textContent = title;
        document.getElementById('manage_status').value = status;
        document.getElementById('manage_response').value = response ?? '';
    });
}

    });
</script>
@endpush