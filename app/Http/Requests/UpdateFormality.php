<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormality extends FormRequest
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
            'user_id' => 'required|numeric',
            'section_id' =>'required|numeric',
            'serie_id' =>'required|numeric',
            'subserie_id' => 'nullable|numeric',
            'opening_date' => 'required|date',
            'close_date' => 'required|date',
            'consecutive' => 'required|numeric',
            'legajo' => 'required|numeric',
            'sort_code' => [
                'string',
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'title'=> [
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'description_id' => 'required|numeric',
            'additional_information'=> [
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'format_id' => 'numeric',
            'documentary_tradition_id' => 'numeric',
            'legajos' => 'numeric',
            'initial_folio' => 'numeric',
            'end_folio' => 'numeric',
            'total_fojas' => 'numeric',
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
                function ($attribute, $value, $fail) {
                    static::validateText($attribute, $value, $fail);
                },
            ],
            'reservation_period' => 'numeric',
            'deadline_extension' => 'numeric',
            'Record_official_number'=> [
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
