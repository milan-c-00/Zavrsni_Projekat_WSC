<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
            'brand_id' => 'required|integer|exists:brands,id',
            'vehicle_model_id' => 'required|integer|exists:vehicle_models,id',
            'year' => 'required|integer|min:1950|max:2050',
            'price' => 'required|integer|min:0',
            'fuel' => 'required|string|max:255',
            'color' => 'nullable|string|max:255',
            'doors' => 'nullable|integer|max:7',
            'description' => 'nullable|string|max:512',
            'vehicle_image' => 'image',
            'vehicle_specs' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt'
        ];
    }
}
