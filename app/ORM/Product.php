<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\Product
 *
 * @property int $id
 * @property string $product_cd 商品CD
 * @property string $name 商品名
 * @property int $product_category_id 商品カテゴリーID
 * @property int $without_tax_sell_price 販売単価(税抜き)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\ORM\ProductCategory $productCategory
 * @property-read \App\ORM\ProductImage $productImage
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereForwardMatch($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereInclude($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereMatch($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereProductCd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereRange($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereSame($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Product whereWithoutTaxSellPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Product withoutTrashed()
 * @mixin \Eloquent
 */

 /**
 * @SWG\Definition(definition="product", type="object")
 */

class Product extends BaseModel
{
    /**
     * @SWG\Property(property="id",description="ID", type="integer")
     * @SWG\Property(property="product_cd",description="商品CD", type="string")
     * @SWG\Property(property="name",description="商品名", type="string")
     * @SWG\Property(property="product_category_id",description="商品カテゴリーID", type="integer")
     * @SWG\Property(property="without_tax_sell_price_first",description="販売単価(税抜き)", type="integer")
    */

    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'product_cd',
        'name',
        'product_category_id',
        'without_tax_sell_price',
    ];

    /**
     * 商品→商品カテゴリを取得
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * 商品→商品イメージを取得
     */
    public function productImage()
    {
        return $this->hasOne(ProductImage::class);
    }
}
