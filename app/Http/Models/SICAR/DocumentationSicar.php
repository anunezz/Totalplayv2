<?php

namespace App\Http\Models\SICAR;

use Illuminate\Database\Eloquent\Model;

class DocumentationSicar extends Model
{
    protected $connection ='sicar';
    protected $table = 'documentation';
}
