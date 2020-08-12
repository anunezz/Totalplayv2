<?php

namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

class CatSection extends Model
{
    protected $fillable = ['name', 'cat'];

    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }
}
