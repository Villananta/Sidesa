@extends('layout.app')

@section('content')

    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success"
            });
        </script>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Notifikasi</h1>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">

                    @if (count($notifications) < 1)
                        <p class="text-center pt-3 text-muted">Tidak ada notifikasi.</p>
                    @else
                        <table class="table table-bordered table-hovered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pesan</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $notifications->firstitem() - 1 }}</td>
                                        <td>{{ $item->data['message'] ?? 'Notifikasi baru' }}</td>
                                        <td>{{ $item->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                                        <td>
                                            @if ($item->read_at)
                                                <span class="badge badge-secondary">Sudah dibaca</span>
                                            @else
                                                <span class="badge badge-danger">Belum dibaca</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$item->read_at)
                                                <form action="{{ route('notifications.markAsRead', $item->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-check"></i> Tandai sudah dibaca
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($notifications->lastPage() > 1)
                            <div class="card-footer">
                                {{ $notifications->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection