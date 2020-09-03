<?php

namespace App\Http\Models\SICAR;

use Illuminate\Database\Eloquent\Model;

class DocumentarySicar extends Model
{
    protected $connection ='sicar';
    protected $table = 'documentary_value';
}
