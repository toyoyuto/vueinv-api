<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\Discount
 *
 * @property int $id
 * @property int $discount_type 割引種別(1:会計,2:商品)
 * @property string $name 割引名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Discount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Discount withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Discount withoutTrashed()
 * @mixin \Eloquent
 */
class Discount extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'discounts';

    protected $fillable = [
        'discount_type',
        'name',
    ];
}
