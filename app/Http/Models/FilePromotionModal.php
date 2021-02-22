<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FilePromotionModal extends Model
{
    protected $fillable = ['promotion_id','fileName','fileNameHash','isActive'];
    protected $appends  = ['hash'];

    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }
}
