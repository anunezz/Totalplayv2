<?php namespace App\Http\Models\Cats;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CatProfile
 *
 * @property int $id
 * @property string $name
 * @property int $isActive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CatProfile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CatProfile extends Model
{
    //
}
