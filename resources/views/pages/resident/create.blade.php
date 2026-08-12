@extends('layout.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Penduduk</h1>
    </div>

    <!-- @if($errors->any())
        @dd($errors->all())
    @endif -->

    <div class="row">
        <div class="col">

            <form action='/resident' method="post">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="nik">NIK</label>
                            <input type="number" inputmode="numeric" name="nik" id="nik" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="gender">Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="date_of_birth"> Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="place_of_birth"> Tempat Lahir</label>
                            <input type="text" name="place_of_birth" id="place_of_birth" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="address"> Alamat
                            </label>
                            <textarea name="address" id="address" cols="30" row="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group mb-3">
                        <label for="religion">Agama</label>
                        <select name="religion" id="religion" class="form-control">
                            <option value="islam" selected>Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="katholik">Khatolik</option>
                            <option value="hindu">Hindu</option>
                            <option value="budha">Budha</option>
                            <option value="khonghucu">khonghucu</option>
                        </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="marital_status">Status</label>
                            <select name="marital_status" id="marital_status" class="form-control">
                                <option value="single">Belum Menikah</option>
                                <option value="married">Sudah Menikah</option>
                                <option value="widower">Duda</option>
                                <option value="widow">Janda</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="occupation"> Pekerjaan</label>
                            <input type="text" name="occupation" id="occupation" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone"> No. Telepon</label>
                            <input type="text" inputmode="numeric" name="phone" id="phone" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="aktif">Aktif</option>
                                <option value="pindahan">Pindahan</option>
                                <option value="meninggal">Meninggal</option>
                            </select>
                        </div>
                    </div>
                    <div class=card-footer>
                        <div class="d-flex justify-content-end" style="gap:10px">
                            <a href="/resident" class="btn btn-outline-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>


@endsection


