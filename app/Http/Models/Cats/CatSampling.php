<?php namespace App\Http\Models\Cats;

use App\Http\Models\Formalities;
use Illuminate\Database\Eloquent\Model;

class CatSampling extends Model
{
    protected $fillable = ['quality', 'cat_series_id'];

    protected $appends = ['hash', 'format_rec'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }

    public function formalities()
    {
        return $this->hasOne(
            Formalities::class,
            'quality_id'
        );
    }

    public function serie()
    {
        return $this->belongsTo(CatSeries::class, 'cat_series_id');
    }

    public function subserie()
    {
        return $this->belongsToMany(CatSampling::class,
            'sampling_subseries',
            'cat_sampling_id',
            'cat_subserie_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->when(! empty ($search), function ($query) use ($search) {

            return $query->where(function($q) use ($search)
            {
                $q->where('quality', 'like', '%' .$search . '%');
            });
        });
    }

    public function getFormatRecAttribute()
    {
        do{
            $findSpace = strpos($this->quality, '&nbsp; &nbsp;');

            if ($findSpace != false) $this->quality = str_replace('&nbsp; &nbsp;','&nbsp;',$this->quality);
        }while($findSpace != false);

        if (substr_count($this->quality, '</p>')>1){
            $onlyText = explode("</p>", $this->quality);
            $fullText = '';

            foreach ($onlyText as $text){
                if (strpos($text, '">&nbsp;')==false){
                    $fullText = $fullText.$text;
                }
            }

            $format = str_replace('margin-left:','',$fullText);
            $format = str_replace('text-align:','',$format);

            return $format;
        }else{

            $format = str_replace('margin-left:','',$this->quality);
            $format = str_replace('text-align:','',$format);
            return $format;
        }

    }
}
