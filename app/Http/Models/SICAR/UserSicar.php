<?php

namespace App\Http\Models\SICAR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSicar extends Model
{
    use SoftDeletes;

    protected $connection ='sicar';
    protected $table = 'users';
}
