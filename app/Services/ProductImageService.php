<?php

namespace App\Services;

use App\ORM\ProductImage;
use App\Http\Requests\ProductImageStoreRequest;
use App\Http\Requests\ProductImageUpdateRequest;
use App\Http\Requests\ProductImageSearchRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Throwable;

class ProductImageService
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
        $query = ProductImage::whereSame([
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
     * @param ProductImageStoreRequest $value
     *
     * @throws Throwable
     *
     * @return ProductImage
     */
    public function store(ProductImageStoreRequest $value)
    {
        $productImage = new ProductImage();

        DB::transaction(function () use (&$productImage, $value): void {
            $productImage->fill($value->toArray())->save();
        });

        return $productImage;
    }

    /**
     * 更新
     *
     * @param ProductImageUpdateRequest $value
     * @param ProductImage $productImage
     *
     * @throws Throwable
     *
     * @return ProductImage
     */
    public function update(ProductImageUpdateRequest $value, ProductImage $productImage)
    {
        DB::transaction(function () use (&$productImage, $value): void {
            $productImage->fill($value->toArray())->save();
        });

        return $productImage;
    }

    /**
     * 削除
     *
     * @param ProductImage $productImage
     *
     * @throws Throwable
     *
     * @return ProductImage
     */
    public function destroy(ProductImage $productImage)
    {
        DB::transaction(function () use (&$productImage): void {
            $productImage->delete();
        });

        return $productImage;
    }

    /**
     * 検索
     *
     * @param ProductImageSearchRequest $value
     *
     * @return Collection
     */
    public function search(ProductImageSearchRequest $value)
    {
        $query   = $this->query($value->toArray());
        return $query->get();
    }
}
