<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Formalities extends Model
{
    protected $fillable = ['section_id', 'serie_id', 'subserie_id', 'opening_date', 'close_date', 'consecutive',
        'legajo', 'sort_code', 'title', 'scope_and_content', 'format_id', 'documentary_tradition_id', 'legajos',
        'initial_folio', 'end_folio', 'total_fojas', 'question_one', 'question_two', 'transparency_esolution_id',
        'nature_information_id', 'classification_reason_id', 'classification_date', 'name_titular', 'transparency_proceedings',
        'restricted_parts', 'legal_basis', 'reservation_period', 'deadline_extension', 'Record_official_number',
        'declassification_date', 'public_server',
    ];
}
