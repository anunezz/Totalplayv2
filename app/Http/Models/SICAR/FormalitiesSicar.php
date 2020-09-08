<?php

namespace App\Http\Models\SICAR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormalitiesSicar extends Model
{
    use SoftDeletes;

    protected $connection ='sicar';
    protected $table = 'formalities';
    protected $appends = ['hash'];

    protected $with = ['user','section','serie','subserie','documentary',
                        'documentation','term','inventory','soport'];

    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function user()
    {
        return $this->belongsTo(
            UserSicar::class,
            'user_id'
        );
    }
    public function section()
    {
        return $this->belongsTo(
            SectionSicar::class,
            'key_section',
            'key_section'
        );
    }

    public function serie()
    {
        return $this->belongsTo(
            SerieSicar::class,
            'key_serie',
            'key_serie'
        );
    }

    public function subserie()
    {
        return $this->belongsTo(
            SubSerieSicar::class,
            'key_subserie',
            'key_subserie'
        );
    }

    public function documentary()
    {
        return $this->belongsTo(
            DocumentarySicar::class,
            'documentary_value_id',
            'id'
        );
    }

    public function documentation()
    {
        return $this->belongsTo(DocumentationSicar::class,
            'documentation_id',
            'id'
        );
    }

    public function term()
    {
        return $this->belongsTo(TermSicar::class,
            'terms_id',
            'id'
        );
    }

    public function inventory()
    {
        return $this->belongsTo(
            InventorySicar::class,
            'inventory_id',
            'id'
        );
    }

    public function soport()
    {
        return $this->belongsTo(
            SoportSicar::class,
            'soport_id',
            'id'
        );
    }

}
