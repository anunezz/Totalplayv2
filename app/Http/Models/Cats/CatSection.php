<?php

namespace App\Http\Models\Cats;

use App\Http\Models\Formalities;
use Illuminate\Database\Eloquent\Model;

class CatSection extends Model
{
    protected $fillable = ['name', 'cat'];

    protected $appends = ['full_name', 'hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function getFullNameAttribute()
    {
        return $this->code . '-' . $this->name;
    }

    public function formalities()
    {
        return $this->hasOne(
            Formalities::class,
            'section_id'
        );
    }

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('name', 'like', '%' .$search . '%')
                    ->orWhere ('code', 'like', '%' .$search . '%');
            });
        });
    }
}
