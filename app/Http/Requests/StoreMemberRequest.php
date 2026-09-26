<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:50|unique:members,nim',
            'email' => 'required|string|email|max:100|unique:members,email',
            'nomor_telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:100',
            'status' => 'required|string|in:aktif,nonaktif',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama member wajib diisi',
            'nim.required' => 'NIM member wajib diisi',
            'email.required' => 'Email member wajib diisi',
            'nomor_telepon.required' => 'Nomor telepon member wajib diisi',
            'alamat.required' => 'Alamat member wajib diisi',
            'status.required' => 'Status member wajib diisi',
        ];
    }
}