<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cat_profile_id' => 'integer',
            'cat_unit_id' => 'integer',
            'cat_administrative_unit_id' => 'array',
            'name' => 'required|string|max:100|regex:(^([a-zA-Z0-9ÁÉÍÓÚáéíóúñÑÄËÏÖÜäëïöü\s]+)+$)',
            'firstName' => 'required|string|max:100|regex:(^([a-zA-Z0-9ÁÉÍÓÚáéíóúñÑÄËÏÖÜäëïöü\s]+)+$)',
            'secondName' => 'required|string|max:100|regex:(^([a-zA-Z0-9ÁÉÍÓÚáéíóúñÑÄËÏÖÜäëïöü\s]+)+$)',
            'isActive' => 'boolean',
        ];
    }
}
