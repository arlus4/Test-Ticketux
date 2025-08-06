<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode' => 'required|string|max:10|unique:coas,kode,' . $this->route('coa')?->id,
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kode.required' => 'Kode COA wajib diisi.',
            'kode.string' => 'Kode COA harus berupa teks.',
            'kode.max' => 'Kode COA maksimal 10 karakter.',
            'kode.unique' => 'Kode COA sudah digunakan.',
            'nama.required' => 'Nama COA wajib diisi.',
            'nama.string' => 'Nama COA harus berupa teks.',
            'nama.max' => 'Nama COA maksimal 255 karakter.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
        ];
    }
}
