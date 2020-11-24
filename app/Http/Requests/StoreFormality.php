<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormality extends FormRequest
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
            'section_id' =>'required|numeric',
            'serie_id' =>'required|numeric',
            'subserie_id' => 'nullable|numeric',
            'opening_date' => 'required|date',
            'close_date' => 'required|date',
            'consecutive' => 'required|numeric|min:0',
            'legajo' => 'required|numeric|min:0',
            'generating_area' => [
                'string', 'nullable',
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'sort_code' => [
                'string','max:255',
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'title'=> [
                'max:255',
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'description_id' => 'required|numeric',
            'additional_information'=> [
                'max:250',
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'format_id' => 'numeric',
            'documentary_tradition_id' => 'numeric',
            'legajos' => 'numeric|min:0',
            'initial_folio' => 'numeric|min:0',
            'end_folio' => 'numeric|min:0',
            'total_fojas' => 'numeric|min:0',
            'question_one' => 'boolean',
            'question_two' => 'nullable|boolean',
            'haveQuality' => 'nullable|boolean',
            'transparency_resolution_id' => 'nullable|numeric',
            'nature_information_id' => 'nullable|numeric',
            'classification_reason_id' => 'nullable|numeric',
            'classification_date' => 'nullable|date',
            'name_titular'=> [
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'transparency_proceedings'=> [
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'restricted_parts'=> [
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'legal_basis'=> [
                'max:255',
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'reservation_period' => 'numeric|min:0',
            'deadline_extension' => 'numeric|min:0',
            'Record_official_number'=> [
                'max:255',
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'declassification_date' => 'nullable|date',
            'name_public_server'=> [
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'position_public_server'=> [
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'unit_id' => 'numeric',
            'type_selection' => 'numeric',
            'quality_id' => 'nullable|numeric',

        ];
    }

    public static function validateText($attribute, $value, $fail)
    {
        if( strlen($value) > 0 ){
            if ( preg_match('/(<\\xml|<\/script|<\/|<\\script|<script|<xml|<\\|\?>|<\?xml|(<\?php|<\?|\?\>)|java|xss|htaccess)/im', $value) === 1  ) {
                $fail($attribute.' incorrecto.');
            }
        }
    }
}
