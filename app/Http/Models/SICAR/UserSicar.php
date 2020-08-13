<?php

namespace App\Http\Models\SICAR;

use Illuminate\Database\Eloquent\Model;

class UserSicar extends Model
{
    protected $connection ='sicar';
    protected $table = 'users';
}
