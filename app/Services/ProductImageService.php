<?php

namespace App\Services;

use App\Http\Requests\ProductImageSearchRequest;
use App\Http\Requests\ProductImageStoreRequest;
use App\Http\Requests\ProductImageUpdateRequest;
use App\ORM\ProductImage;
use App\ORM\Product;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;
use Log;

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
     * 登録
     *
     * @param array $value
     *
     * @throws Throwable
     *
     * @return ProductImage
     */
    public function store(array $value)
    {
        $productImage = new ProductImage();

        DB::transaction(function () use (&$productImage, $value): void {
            $productImage->fill($value)->save();
        });

        return $productImage;
    }

    /**
     * 更新
     *
     * @param array $value
     * @param ProductImage $productImage
     *
     * @throws Throwable
     *
     * @return ProductImage
     */
    public function update(array $value, ProductImage $productImage)
    {
        DB::transaction(function () use (&$productImage, $value): void {
            $productImage->fill($value)->save();
        });

        return $productImage;
    }

    /**
     * 削除(物理)
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
            $productImage->forceDelete();
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

    /**
     * 商品画像を削除する
     *
     * @param ProductImage $productImage
     *
     * @return void
     */
    public function clear(ProductImage $productImage): void
    {
        // ファイルパスを取得
        $path = ProductImage::find($productImage->id)->path;

        // 画像削除
        resolve(S3ImageService::class)->removeImage($path);
    }

    /**
     * 商品画像の登録(ファイルパスの生成)
     *  ファイルパスの生成
     *  DB登録
     *  S3登録
     * @param Product　$product
     *
     * @return void
     */
    public function save(Product $product, $image): void
    {
        // ファイルパス生成
        $matches = S3ImageService::checkFormatBase64($image);
        // $matches[2]画像の実データが格納されている
        $data = $matches[2];
        $fill_name = S3ImageService::addImageExtension(str_random());
        $path = "product_image/{$product->id}/{$fill_name}";

        $product_image_value = [
            'product_id' => $product->id,
            'path'       => $path,
        ];
        // 画像DB登録
        resolve(ProductImageService::class)->store($product_image_value);
        // 画像をS3に保存
        resolve(S3ImageService::class)->saveImage($path, $data);
    }
}
