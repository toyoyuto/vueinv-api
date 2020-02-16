<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *     definition="product_category", 
 *     type="object", 
 *     @SWG\Property(property="id",description="ID", type="integer"),
 *     @SWG\Property(property="name",description="商品カテゴリー名", type="string"),
 *     @SWG\Property(property="consumption_tax_id",description="消費税ID", type="integer")
 */

class ProductCategory extends Model
{
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
     *
     */
    public function consumptionTax()
    {
        return $this->belongsTo(ConsumptionTax::class);
    }
}
