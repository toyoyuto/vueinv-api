<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\AccountProduct
 *
 * @property int $id
 * @property int $account_id 会計ID
 * @property int $product_id 商品ID
 * @property int $without_tax_sell_price 販売単価(税抜き)
 * @property int|null $discount_id 割引ID
 * @property int $product_discount_amount 商品割引金額
 * @property int $consumption_tax_rate 適用消費税率
 * @property int $account_product_amount 会計商品金額
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereAccountProductAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereConsumptionTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereProductDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountProduct whereWithoutTaxSellPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountProduct withoutTrashed()
 * @mixin \Eloquent
 */
class AccountProduct extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'account_products';

    protected $fillable = [
        'account_id',
        'product_id',
        'without_tax_sell_price',
        'discount_id',
        'product_discount_amount',
        'consumption_tax_rate',
        'account_product_amount',
    ];
}
