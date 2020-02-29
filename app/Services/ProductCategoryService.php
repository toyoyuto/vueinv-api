<?php

namespace App\Services;

use App\Http\Requests\ProductCategorySearchRequest;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\ORM\ProductCategory;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductCategoryService
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
        $query = ProductCategory::whereSame([
            'id' => $params->get('id'),
        ]);

        // 部分一致
        $query->whereMatch([
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
        ]);

        return $query;
    }

    /**
     * 登録、更新
     *
     * @param ProductCategoryStoreRequest $value
     *
     * @throws Throwable
     *
     * @return ProductCategory
     */
    public function store(ProductCategoryStoreRequest $value)
    {
        $productCategory = new ProductCategory();

        DB::transaction(function () use (&$productCategory, $value): void {
            $productCategory->fill($value->toArray())->save();
        });

        return $productCategory;
    }

    /**
     * 更新
     *
     * @param ProductCategoryUpdateRequest $value
     * @param ProductCategory $productCategory
     *
     * @throws Throwable
     *
     * @return ProductCategory
     */
    public function update(ProductCategoryUpdateRequest $value, ProductCategory $productCategory)
    {
        DB::transaction(function () use (&$productCategory, $value): void {
            $productCategory->fill($value->toArray())->save();
        });

        return $productCategory;
    }

    /**
     * 削除
     *
     * @param ProductCategory $productCategory
     *
     * @throws Throwable
     *
     * @return ProductCategory
     */
    public function destroy(ProductCategory $productCategory)
    {
        DB::transaction(function () use (&$productCategory): void {
            $productCategory->delete();
        });

        return $productCategory;
    }

    /**
     * 検索
     *
     * @param ProductCategorySearchRequest $value
     *
     * @return Collection
     */
    public function search(ProductCategorySearchRequest $value)
    {
        $query   = $this->query($value->toArray());

        return $query->get();
    }
}
