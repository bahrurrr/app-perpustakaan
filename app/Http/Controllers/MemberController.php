<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        ['id' => 1, 'nama' => 'Luthfi', 'nim' => '3125600069', 'email' => 'luthfi@gmail.com', 'nomor_telepon' => '085928978578', 'alamat' => 'Surabaya', 'status' => 'Mahasiswa'],
        ['id' => 2, 'nama' => 'Bahrur', 'nim' => '3125600069', 'email' => 'luthfi@gmail.com', 'nomor_telepon' => '085928978578', 'alamat' => 'Surabaya', 'status' => 'Mahasiswa'],
        ['id' => 3, 'nama' => 'Rozaq', 'nim' => '3125600069', 'email' => 'luthfi@gmail.com', 'nomor_telepon' => '085928978578', 'alamat' => 'Surabaya', 'status' => 'Mahasiswa'],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Member \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "MemberController@destroy, id: {$id}";
    }
}
