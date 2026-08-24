@extends ('layout.app')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
        <a href="/resident/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>

    <div class="row d-flex justify-content-center text-center">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                <table class= "table table-responsive table-bordered table-hovered">
                    <thead> 
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Agama</th>
                            <th>Status Perkawinan</th>
                            <th>Pekerjaan</th>
                            <th>No Telepon</th>
                            <th>status Penduduk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    @if (count($residents) < 1)
                    <tbody>

                        <tr>
                            <td colspan="11"> <p class="text-center pt-3">Tidak ada data penduduk.</p></td>
                        </tr>
                    </tbody>
                    @else
                    <tbody>
                        @foreach ($residents as $resident)
                            <tr>
                                <td>{{ $loop->iteration + $residents-> firstitem() - 1 }}</td>
                                <td>{{ $resident->nik }}</td>
                                <td>{{ $resident->name }}</td>
                                <td>{{ $resident->gender }}</td>
                                <td>{{ $resident->place_of_birth }}, {{ $resident->date_of_birth }}</td>
                                <td>{{ $resident->address }}</td>
                                <td>{{ $resident->religion }}</td>
                                <td>{{ $resident->marital_status }}</td>
                                <td>{{ $resident->occupation }}</td>
                                <td>{{ $resident->phone }}</td>
                                <td>{{ $resident->status }}</td>
                                <td>
                                    <div class="d-flex">
                                    <a href="/resident/{{ $resident->id }}/edit" class="btn btn-sm btn-warning d-inline-block mr-2">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <button type="button" class="btn btn-sm btn-danger mr-2"
                                        data-toggle="modal"
                                        data-target="#confirmationDelete"
                                        data-id="{{ $resident->id }}">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                    @if ($resident->user)
                                        <button type="button" class="btn btn-sm btn-info"
                                            data-toggle="modal"
                                            data-target="#detailAkunModal"
                                            data-name="{{ $resident->user->name }}"
                                            data-email="{{ $resident->user->email }}">
                                            Lihat Akun
                                        </button>
                                    @endif
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>   
            </div> 
            @if ($residents-> lastPage() > 1)
            <div class="card-footer">
                {{ $residents ->links('pagination::bootstrap-5') }}
            </div>
            @endif
            </div>
        </div>
    </div>
    @include('pages.resident.detail-akun')
    @include('pages.resident.confirmation-delete')         
@endsection