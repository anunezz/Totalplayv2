<?php

namespace App\Http\Models;

use App\Http\Models\Cats\CatSeries;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Formalities extends Model
{
    protected $fillable = ['user_id','section_id', 'serie_id', 'subserie_id', 'opening_date', 'close_date', 'consecutive',
        'legajo', 'sort_code', 'title', 'scope_and_content', 'format_id', 'documentary_tradition_id', 'legajos',
        'initial_folio', 'end_folio', 'total_fojas', 'question_one', 'question_two', 'transparency_resolution_id',
        'nature_information_id', 'classification_reason_id', 'classification_date', 'name_titular', 'transparency_proceedings',
        'restricted_parts', 'legal_basis', 'reservation_period', 'deadline_extension', 'Record_official_number',
        'declassification_date', 'public_server',
    ];

    protected $appends = ['hash'];

    public function scopeSearch($query, $filters)
    {
        return $query->where(function ($q) use ($filters) {
            $filters = json_decode($filters);

            if (!empty($filters->classification)){
                $q->where('sort_code', 'like', '%' .$filters->classification . '%');
            }
        });

    }

    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function serie()
    {
        return $this->belongsTo(CatSeries::class);
    }
}
