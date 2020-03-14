<?php

namespace App\Services;

use App\Http\Requests\ProductSearchRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\ORM\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductService
{
    /**
     * 検索を行う
     *
     * @param array $params
     *
     * @return Builder
     */
    public function query(array $params)
    {
        $params = collect($params);

        // 同一
        $query = Product::whereSame([
            'id'                  => $params->get('id'),
            'product_category_id' => $params->get('product_category_id'),
        ]);

        // 部分一致
        $query->whereMatch([
            'name'       => $params->get('name'),
            'product_cd' => $params->get('product_cd'),
        ]);

        // 前方一致
        $query->whereForwardMatch([
        ]);

        // 包含
        $query->whereInclude([
        ]);

        // 範囲
        // 両端を含める場合はfirst、last
        // 終端を含めない場合はbegin、end
        $query->whereRange([
            'created_at' => [
                'first' => $params->get('created_at_first'),
                'last'  => $params->get('created_at_last'),
            ],
            'updated_at' => [
                'first' => $params->get('updated_at_first'),
                'last'  => $params->get('updated_at_last'),
            ],
            'without_tax_sell_price' => [
                'first' => $params->get('without_tax_sell_price_first'),
                'last'  => $params->get('without_tax_sell_price_last'),
            ],
        ]);

        $query->with(['productCategory', 'productImage']);

        return $query;
    }

    /**
     * 商品を取得する
     *
     * @param int $product_id
     *
     * @return Collection
     */
    public function show(int $product_id)
    {
        $products = Product::with(['productCategory', 'productImage'])->find($product_id);

      
        return $products;
    }

    /**
     * 登録、更新
     *
     * @param array $value
     *
     * @throws Throwable
     *
     * @return Product
     */
    public function store(array $value)
    {
        $product = new Product();

        DB::transaction(function () use (&$product, $value): void {
            $product->fill($value)->save();
        });

        return $product;
    }

    /**
     * 更新
     *
     * @param array $value
     * @param Product $product
     *
     * @throws Throwable
     *
     * @return Product
     */
    public function update(array $value, Product $product)
    {
        DB::transaction(function () use (&$product, $value): void {
            $product->fill($value)->save();
        });

        return $product;
    }

    /**
     * 削除
     *
     * @param Product $product
     *
     * @throws Throwable
     *
     * @return Product
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use (&$product): void {
            $product->delete();
        });

        return $product;
    }

    /**
     * 検索
     *
     * @param ProductSearchRequest $value
     *
     * @return Collection
     */
    public function search(ProductSearchRequest $value)
    {
        $query   = $this->query($value->toArray());

        return $query->get();
    }
}
