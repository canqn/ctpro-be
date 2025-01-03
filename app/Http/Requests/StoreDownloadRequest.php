<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDownloadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'min:3', 'max:100'],
            'account_id' => ['sometimes', 'integer'],
            'driver_id' => ['sometimes', 'string'],
            'driver_info' => ['sometimes', 'string'],
            'total_download' => ['required', 'integer'],
            'total_date' => ['sometimes', 'datetime'],
        ];
    }
}
