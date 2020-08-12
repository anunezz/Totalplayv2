<?php

namespace App\Http\Models\SICAR;

use Illuminate\Database\Eloquent\Model;

class FormalitiesSicar extends Model
{
    protected $connection ='sicar';
    protected $table = 'formalities';
    protected $primaryKey ='Id';
}
