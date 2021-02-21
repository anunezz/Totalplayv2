<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FirstSesion extends Model
{
    protected $fillable = ['user_id', 'isActive'];
}
