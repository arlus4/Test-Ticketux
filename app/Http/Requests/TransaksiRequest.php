<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksiRequest extends FormRequest
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
            'tanggal' => 'required|date',
            'coa_id' => 'required|exists:coas,id',
            'desc' => 'required|string|max:500',
            'debit' => 'nullable|numeric|min:0',
            'credit' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal transaksi wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'coa_id.required' => 'COA wajib dipilih.',
            'coa_id.exists' => 'COA yang dipilih tidak valid.',
            'desc.required' => 'Deskripsi transaksi wajib diisi.',
            'desc.string' => 'Deskripsi harus berupa teks.',
            'desc.max' => 'Deskripsi maksimal 500 karakter.',
            'debit.numeric' => 'Debit harus berupa angka.',
            'debit.min' => 'Debit tidak boleh negatif.',
            'credit.numeric' => 'Credit harus berupa angka.',
            'credit.min' => 'Credit tidak boleh negatif.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $debit = (float) $this->input('debit', 0);
            $credit = (float) $this->input('credit', 0);

            // Either debit or credit must be greater than 0, but not both
            if ($debit == 0 && $credit == 0) {
                $validator->errors()->add('debit', 'Either debit or credit amount must be greater than 0.');
                $validator->errors()->add('credit', 'Either debit or credit amount must be greater than 0.');
            }

            if ($debit > 0 && $credit > 0) {
                $validator->errors()->add('debit', 'Only one of debit or credit should have a value, not both.');
                $validator->errors()->add('credit', 'Only one of debit or credit should have a value, not both.');
            }
        });
    }
}
