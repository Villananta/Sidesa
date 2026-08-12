@extends ('layout.app')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
        <a href="/resident/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                <table class= "table table-responsive table-bordered table-hovered"
                    <thead> 
                        <tr>
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

                                    <form action="/resident/{{ $resident->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-eraser"></i>
                                        </button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @endif

                </table>   
            </div> 
            </div>
        </div>
    </div>
              
@endsection