@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
    <h1>Edit Member</h1>
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar member</a></p>


    <form action="{{ route('members.update', $member['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', $member['nama']) }}">
        @error('nama')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="nim">NIM</label>
        <input type="text" name="nim" id="nim" value="{{ old('nim', $member['nim']) }}">
        @error('nim')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{ old('email', $member['email']) }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="nomor_telepon">No. Telepon</label>
        <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $member['nomor_telepon']) }}">
        @error('nomor_telepon')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $member['alamat']) }}">
        @error('alamat')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="status">Status</label>
        <input type="text" name="status" id="status" value="{{ old('status', $member['status']) }}">
        @error('status')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn">Simpan</button>
    </form>

@endsection