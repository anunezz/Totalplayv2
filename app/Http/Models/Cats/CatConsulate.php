<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CatConsulate
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatConsulate whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class CatConsulate extends Model
{
    protected $appends = ['hash'];

    public function getHashAttribute()
    {
        return encrypt($this->id);
    }
}
