<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Consulate;
use App\Http\Models\Cats\CatConsulate;
use App\User;



class Operative extends Model
{



 protected $fillable = [
'user_id',
'consulate_id',
'short_arms_description',
'short_arms',
'long_weapons_description',
'long_weapons',
'barret_description',
'barret',
'description_chargers',
'chargers',
'explosives_description',
'explosives',
'rocket_launcher_description',
'rocket_launcher',
'parts_accessories_description',
'parts_accessories',
'mexicans',
'americans',
'others',
'type_of_operative',
'link',
'country',
'state',
'localidad',
'longitud',
'latitud'];

// public function consulate(){
//     return $this->belongsTo(Consulate::class);
// }



}
