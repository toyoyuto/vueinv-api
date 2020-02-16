<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\AccountDiscount
 *
 * @property int $id
 * @property int $account_id 会計ID
 * @property int $discount_id 割引ID
 * @property int $discount_amount 割引金額
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountDiscount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountDiscount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountDiscount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountDiscount withoutTrashed()
 * @mixin \Eloquent
 */
class AccountDiscount extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'account_discounts';

    protected $fillable = [
        'account_id',
        'discount_id',
        'discount_amount',
    ];
}
