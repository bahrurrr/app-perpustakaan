@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
    <h1>Profil Pengguna</h1>

    @if (session('success'))
        <div class="alert-success" style="background: #d1fae5; color: #065f46; padding: 10px 14px; border-radius: 4px; margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; max-width: 500px; margin-bottom: 24px;">
        <h3 style="margin-top: 0;">Informasi Akun</h3>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
    </div>

    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; max-width: 500px;">
        <h3 style="margin-top: 0;">Ganti Password</h3>

        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <label for="current_password" style="display: block; margin-top: 12px; font-weight: bold;">Password Lama</label>
            <input type="password" name="current_password" id="current_password" style="width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box;">
            @error('current_password')
                <div style="color: #b91c1c; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
            @enderror

            <label for="password" style="display: block; margin-top: 12px; font-weight: bold;">Password Baru</label>
            <input type="password" name="password" id="password" style="width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box;">
            @error('password')
                <div style="color: #b91c1c; font-size: 14px; margin-top: 4px;">{{ $message }}</div>
            @enderror

            <label for="password_confirmation" style="display: block; margin-top: 12px; font-weight: bold;">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation" style="width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box;">

            <button type="submit" style="margin-top: 20px; padding: 10px 18px; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                Perbarui Password
            </button>
        </form>
    </div>
@endsection
