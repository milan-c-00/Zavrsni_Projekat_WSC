<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationsExportRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'brand_id' => 'integer|exists:brands,id',
            'vehicle_model_id' => 'integer|exists:vehicle_models,id',
            'min_price' => 'integer',
            'max_price' => 'integer',
            'from_date' => 'date',
            'to_date' => 'date'
        ];
    }
}
