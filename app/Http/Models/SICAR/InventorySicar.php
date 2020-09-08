<?php

namespace App\Http\Models\SICAR;

use Illuminate\Database\Eloquent\Model;

class InventorySicar extends Model
{
    protected $connection ='sicar';
    protected $table = 'inventory';
}
