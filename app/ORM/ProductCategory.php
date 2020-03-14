<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\ProductCategory
 *
 * @property int $id
 * @property string $name 商品カテゴリー名
 * @property int $consumption_tax_id 消費税ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\ORM\ConsumptionTax $consumptionTax
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ProductCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory whereConsumptionTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ProductCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ProductCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ProductCategory extends Model
{
    /**
     * @SWG\Definition(
     *      definition="ProductCategoryResource", 
     *      type="object",
     *      @SWG\Property(property="id",description="ID", type="integer"),
     *      @SWG\Property(property="name",description="商品カテゴリー名", type="string"),
     *      @SWG\Property(property="consumption_tax_id",description="消費税ID", type="integer"),
     *      @SWG\Property(property="deleted_at",description="削除日時", type="string", format="dateTime"),
     * )
     */

    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'consumption_tax_id',
    ];

    /**
     * 商品カテゴリ→消費税取得
     */
    public function consumptionTax()
    {
        return $this->belongsTo(ConsumptionTax::class);
    }
}
