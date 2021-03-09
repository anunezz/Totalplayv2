<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Wallpaper extends Model
{
    protected $fillable = ['fileName', 'fileNameHash','color','isColor'];
}
