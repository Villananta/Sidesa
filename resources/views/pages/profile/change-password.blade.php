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
        <h1 class="h3 mb-0 text-gray-800">Ubah Password</h1>
    </div>


    <div class="row">
        <div class="col">

            <form action="/change-password/{{ auth()->user()->id }}" method="post">
                @csrf
                
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="old_password">Password Lama</label>
                            <input type="password" name="old_password" id="old_password"
                            class="form-control @error('old_password') is-invalid @enderror"
                            >
                            @error('old_password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password">Password Baru</label>
                            <input type="text" name="new_password" id="new_password"
                            class="form-control @error('new_password') is-invalid @enderror"
                            value="{{ old('new_password', auth()->user()->new_password) }}">
                            @error('new_password')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class=footer style="margin-top: 5%">
                        <div class="d-flex justify-content-end" style="gap:10px"   >
                            <a href="/resident" class="btn btn-outline-secondary">Kembali</a>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>


@endsection


