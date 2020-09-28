<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatInventory extends Model
{
    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

}
