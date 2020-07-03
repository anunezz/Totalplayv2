<?php namespace App\Http\Models;

use App\Http\Traits\CustomModelLogic;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;



class Files extends Model
{
    protected $appends = ['hash'];
    protected $fillable = ['title', 'description', 'document_id', 'isPublished', 'downloadCount', 'isType'];

     function documents(){
         return $this->belongsTo(Document::class,'document_id','id', 'isType');
     }

    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function scopeConsult($query, $search){

        return $query->when(!empty($search), function ($query) use ($search){
            return $query->where(function ($q) use ($search){

                $q->when(!empty($search->title), function ($q) use ($search){
                    return $q->where('title','like','%'.$search->title.'%');
                });


            });
        });
    }
}
