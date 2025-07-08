@extends('layouts.master')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KELOLA PROFILE</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center">
            <!-- Add any header content here if needed -->
            <h6 class="m-0 font-weight-bold text-primary">Edit Profil</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                <i class="fas fa-eye" id="toggle-icon"></i>
                            </span>
                        </div>
                    </div>
                    <small class="text-danger text-sm">* Kosongkan jika tidak ingin mengganti password.</small>
                </div>

                <!-- Tambahkan Script -->
                <script>
                    document.getElementById('toggle-password').addEventListener('click', function () {
                        const passwordField = document.getElementById('password');
                        const toggleIcon = document.getElementById('toggle-icon');

                        if (passwordField.type === 'password') {
                            passwordField.type = 'text';
                            toggleIcon.classList.remove('fa-eye');
                            toggleIcon.classList.add('fa-eye-slash');
                        } else {
                            passwordField.type = 'password';
                            toggleIcon.classList.remove('fa-eye-slash');
                            toggleIcon.classList.add('fa-eye');
                        }
                    });
                </script>


                <!-- Address Field -->
                {{-- <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea name="address" class="form-control" id="address" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                </div> --}}

                <!-- Submit Button -->
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    @include('validasi.notifikasi')
    @include('validasi.notifikasi-error')
@endsection
