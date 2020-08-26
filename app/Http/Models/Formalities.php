<?php

namespace App\Http\Models;

use App\Http\Models\Cats\CatAdministrativeUnit;
use App\Http\Models\Cats\CatDescription;
use App\Http\Models\Cats\CatSeries;
use App\Http\Models\Cats\CatSubseries;
use App\Http\Models\Cats\CatSection;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formalities extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','section_id', 'serie_id', 'subserie_id', 'opening_date', 'close_date', 'consecutive',
        'legajo', 'sort_code', 'title', 'description_id','additional_information', 'format_id', 'documentary_tradition_id',
        'legajos', 'initial_folio', 'end_folio', 'total_fojas', 'question_one', 'question_two', 'transparency_resolution_id',
        'nature_information_id', 'classification_reason_id', 'classification_date', 'name_titular', 'transparency_proceedings',
        'restricted_parts', 'legal_basis', 'reservation_period', 'deadline_extension', 'Record_official_number',
        'declassification_date', 'name_public_server', 'position_public_server','unit_id'
    ];

    protected $with = ['unit'];

    protected $appends = ['hash'];

    public function scopeSearch($query, $filters)
    {
        return $query->where(function ($q) use ($filters) {
            $filters = json_decode($filters);

            $q->whereHas('unit', function($q) use ($filters) {
                if (!empty($filters->determinant)) {
                    $q->where('determinant',$filters->determinant);
                }
            });

            if (!empty($filters->classification)){
                $q->where('sort_code', 'like', '%' .$filters->classification . '%');
            }

            if (!empty($filters->year)){
                $q->whereYear('close_date',$filters->year);
            }
            if (!empty($filters->userId)){
                $q->whereUserId($filters->userId);
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

    public function description()
    {
        return $this->hasOne(CatDescription::class,'id','description_id');
    }

    public function section()
    {
        return $this->belongsTo(CatSection::class);
    }

    public function unit()
    {
        return $this->belongsTo(CatAdministrativeUnit::class);
    }

    public function serie()
    {
        return $this->belongsTo(CatSeries::class);
    }

    public function SubSerie()
    {
        return $this->belongsTo(CatSubseries::class);
    }

}
