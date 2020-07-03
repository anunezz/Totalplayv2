<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Http\Models\Transaction
 *
 * @property int $id
 * @property int $user_id
 * @property int $cat_transaction_type_id
 * @property string $action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction whereCatTransactionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Transaction whereUserId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $fillable = ['cat_transaction_type_id', 'action'];
}
