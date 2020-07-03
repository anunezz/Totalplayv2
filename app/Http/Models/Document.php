<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Document
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $recommendation_id
 * @property string $fileName
 * @property string $fileNameHash
 * @property int $isActive
 * @property int $isType
 * @property int $downloadCount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereFileNameHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereRecommendationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Document whereUserId($value)
 * @mixin \Eloquent
 */
class Document extends Model
{
    protected $appends = ['hash'];

    protected $fillable = ['invoice', 'cat_entity_id', 'date', 'fileName'];

    public function getHashAttribute()
    {
        return encrypt( $this->id );
    }

    public function getIsCreatorAttribute(): bool
    {
        return true;
        //return $this->user_id === auth()->user()->id;
    }
}
