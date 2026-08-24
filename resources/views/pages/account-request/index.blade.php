@extends ('layout.app')

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


    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Permintaan Account</h1>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                <table class= "table table-bordered table-hovered">
                    <thead> 
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                            
                        </tr>
                    </thead>

                    @if (count($users) < 1)
                    <tbody>

                        <tr>
                            <td colspan="11"> <p class="text-center pt-3">Tidak ada data penduduk.</p></td>
                        </tr>
                    </tbody>
                    @else
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + $users-> firstitem() - 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                
                                <td>
                                <div class="d-flex">
                                    <button type="button" class="btn btn-sm btn-success mr-2"
                                        data-toggle="modal"
                                        data-target="#confirmationAction"
                                        data-id="{{ $user->id }}"
                                        data-action="approve"
                                        data-name="{{ $user->name }}">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#confirmationAction"
                                        data-id="{{ $user->id }}"
                                        data-action="reject"
                                        data-name="{{ $user->name }}">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @endif

                </table>   
                @if ($users-> lastPage() > 1)
                <div class="card-footer">
                    {{ $users ->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div> 
            </div>
        </div>
    </div>
    @include('pages.account-request.confirmation-approved')         
@endsection