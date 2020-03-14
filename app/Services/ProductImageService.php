<?php

namespace App\Services;

use App\Http\Requests\ProductImageSearchRequest;
use App\Http\Requests\ProductImageStoreRequest;
use App\Http\Requests\ProductImageUpdateRequest;
use App\ORM\ProductImage;
use App\ORM\Product;
use App\Services\S3ImageService;
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
            $productImage->delete();
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
    public function forceDestroy(ProductImage $productImage)
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
     * 商品画像をS3から削除する
     *
     * @param ProductImage $productImage
     *
     * @return void
     */
    public function clearS3Image(ProductImage $productImage): void
    {
        // ファイルパスを取得
        $path = ProductImage::find($productImage->id)->path;

        // 画像削除
        resolve(S3ImageService::class)->removeImage($path);
    }

    /**
     * 商品に紐づく商品画像の登録
     *  ファイルパスの生成
     *  DB登録
     *  S3登録
     * @param int $product_id
     *
     * @return ProductImage $stored_product_image
     */
    public function save($product_id, $image)
    {
        // ファイルパス生成
        $matches = S3ImageService::checkFormatBase64($image);
        // $matches[2]画像の実データが格納されている
        $data = $matches[2];
        $fill_name = S3ImageService::addImageExtension(str_random());
        $path = "product_image/{$product_id}/{$fill_name}";

        $product_image_value = [
            'product_id' => $product_id,
            'path'       => $path,
        ];
        // 画像DB登録
        $stored_product_image = resolve(ProductImageService::class)->store($product_image_value);
        // 画像をS3に保存
        resolve(S3ImageService::class)->saveImage($path, $data);
        return $stored_product_image;
    }

    /**
     * 商品に紐づく商品画像の再登録
     *  S3画像削除
     *  ファイルパスの生成
     *  DB更新
     *  S3登録
     * @param int $product_id
     *
     * @return ProductImage $updated_product_image
     */
    public function reregistration($product_id, $image)
    {
        // ファイルパスを避難させておく
        $productImage = ProductImage::where('product_id', $product_id)->first();

        // 実ファイルを削除
        resolve(S3ImageService::class)->removeImage($productImage->path);

        // ファイルパス生成
        $matches = S3ImageService::checkFormatBase64($image);
        // $matches[2]画像の実データが格納されている
        $data = $matches[2];
        $fill_name = S3ImageService::addImageExtension(str_random());
        $path = "product_image/{$product_id}/{$fill_name}";

        $product_image_value = [
            'product_id' => $product_id,
            'path'       => $path,
        ];
        // 画像DB更新
        $updated_product_image = resolve(ProductImageService::class)->update($product_image_value, $productImage);
        // 画像をS3に保存
        resolve(S3ImageService::class)->saveImage($path, $data);

        return $updated_product_image;
    }

    /**
     * 商品に紐づく商品画像の削除
     *  DB論理削除
     *  S3は削除しない
     * @param int $product_id
     *
     * @return ProductImage $deleted_product_image
     */
    public function clear($product_id)
    {
        // ファイルパスを避難させておく
        $productImage = ProductImage::where('product_id', $product_id)->first();

        $deleted_product_image = $this->destroy($productImage);
        return $deleted_product_image;
    }
}
