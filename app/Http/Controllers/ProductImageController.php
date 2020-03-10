<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageSearchRequest;
use App\Http\Requests\ProductImageStoreRequest;
use App\Http\Requests\ProductImageUpdateRequest;
use App\ORM\ProductImage;
use App\Services\ProductImageService;
use App\Services\S3ImageService;
use Illuminate\Support\Facades\DB;
use Throwable;
use Log;

class ProductImageController extends BaseController
{
    /**
     * @SWG\Get(
     *     path="/api/product_images",
     *     summary="RESOURCE一覧",
     *     description="RESOURCE一覧を返す。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductImages"},
     *
     *     @SWG\Parameter(
     *         name="Authorization",
     *         description="認証トークン",
     *         in="header",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_images",
     *                 ref="#/definitions/product_image"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             ),
     *             @SWG\Property(
     *                 property="errors",
     *                 type="array",
     *                 description="項目別エラーメッセージ",
     *                 @SWG\Items(
     *                     @SWG\Property(property="key", type="array", @SWG\Items(type="string"))
     *                 )
     *             ),
     *         )
     *     )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productImages = ProductImage::orderBy('id')->get();

        return response()->json(compact('productImages'));
    }

    /**
     * @SWG\Post(
     *     path="/api/product_images",
     *     summary="RESOURCE登録",
     *     description="RESOURCEを登録する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductImages"},
     *
     *    @SWG\Parameter(
     *         name="Authorization",
     *         description="認証トークン",
     *         in="header",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="Request",
     *         description="リクエストパラメータ",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @SWG\Schema(
     *             ref="#/definitions/ProductImageStoreRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_image",
     *                 type="object",
     *                 ref="#/definitions/product_image"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             ),
     *             @SWG\Property(
     *                 property="errors",
     *                 type="array",
     *                 description="項目別エラーメッセージ",
     *                 @SWG\Items(
     *                     @SWG\Property(property="key", type="array", @SWG\Items(type="string"))
     *                 )
     *             ),
     *         )
     *     )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param ProductImageStoreRequest $request
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductImageStoreRequest $request)
    {
        $product_image =
            DB::transaction(function () use ($request) {
                // ファイルパス生成
                $matches = S3ImageService::checkFormatBase64($request->input('image'));
                // $matches[2]画像の実データが格納されている
                $data = $matches[2];
                $fill_name = S3ImageService::addImageExtension(str_random());
                $path = "product_image/{$request->input('product_id')}/{$fill_name}";

                $product_image_value = [
                    'product_id' => $request->input('product_id'),
                    'path'       => $path,
                ];
                // DB登録
                $stored_product_image = resolve(ProductImageService::class)->store($product_image_value);
                // 画像をS3に保存
                resolve(S3ImageService::class)->saveImage($path, $data);

                return $stored_product_image;
            });
        return response()->json(compact('product_image'));

    }

    /**
     * @SWG\Get(
     *     path="/api/product_images/{id}",
     *     summary="RESOURCE取得",
     *     description="RESOURCEを取得する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductImages"},
     *
     *    @SWG\Parameter(
     *         name="Authorization",
     *         description="認証トークン",
     *         in="header",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(in="path", required=true, name="id", description="RESOURCEID", type="integer"),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_image",
     *                 type="object",
     *                 ref="#/definitions/product_image"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             ),
     *             @SWG\Property(
     *                 property="errors",
     *                 type="array",
     *                 description="項目別エラーメッセージ",
     *                 @SWG\Items(
     *                     @SWG\Property(property="key", type="array", @SWG\Items(type="string"))
     *                 )
     *             ),
     *         )
     *     )
     * )
     *
     * Display the specified resource.
     *
     * @param ProductImage $productImage
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImage $productImage)
    {
        return response()->json(compact('productImage'));
    }

    /**
     * @SWG\Put(
     *     path="/api/product_images/{id}",
     *     summary="RESOURCE更新",
     *     description="RESOURCEを更新する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductImages"},
     *
     *    @SWG\Parameter(
     *         name="Authorization",
     *         description="認証トークン",
     *         in="header",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(in="path", required=true, name="id", description="RESOURCEID", type="integer"),
     *     @SWG\Parameter(
     *         name="Request",
     *         description="リクエストパラメータ",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @SWG\Schema(
     *             ref="#/definitions/ProductImageUpdateRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_image",
     *                 type="object",
     *                 ref="#/definitions/product_image"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             ),
     *             @SWG\Property(
     *                 property="errors",
     *                 type="array",
     *                 description="項目別エラーメッセージ",
     *                 @SWG\Items(
     *                     @SWG\Property(property="key", type="array", @SWG\Items(type="string"))
     *                 )
     *             ),
     *         )
     *     )
     * )
     *
     * Update the specified resource in storage.
     *
     * @param ProductImageService $service
     * @param ProductImageUpdateRequest $request
     * @param ProductImage $productImage
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductImageUpdateRequest $request, ProductImage $productImage)
    {
        $product_image =
            DB::transaction(function () use ($request, $productImage) {
                // 保存先の画像を削除
                resolve(ProductImageService::class)->clear($productImage);

                // ファイルパス生成ß
                $matches = S3ImageService::checkFormatBase64($request->input('image'));
                // $matches[2]画像の実データが格納されている
                $data = $matches[2];
                $fill_name = S3ImageService::addImageExtension(str_random());
                $path = "product_image/{$request->input('product_id')}/{$fill_name}";

                $product_image_value = [
                    'product_id' => $request->input('product_id'),
                    'path'       => $path,
                ];

                // DB更新
                $update_product_image = resolve(ProductImageService::class)->update($product_image_value, $productImage);

                // 画像をS3に保存
                resolve(S3ImageService::class)->saveImage($path, $data);

                return $update_product_image;
            });
    return response()->json(compact('product_image'));
    }

    /**
     * @SWG\Delete(
     *     path="/api/product_images/{id}",
     *     summary="RESOURCE削除",
     *     description="RESOURCEを論理削除する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductImages"},
     *
     *    @SWG\Parameter(
     *         name="Authorization",
     *         description="認証トークン",
     *         in="header",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(in="path", required=true, name="id", description="RESOURCEID", type="integer"),
     *     @SWG\Parameter(
     *         name="Request",
     *         description="リクエストパラメータ",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @SWG\Schema(
     *             ref="#/definitions/ProductImageUpdateRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_image",
     *                 type="object",
     *                 ref="#/definitions/ProductImageResource"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             ),
     *             @SWG\Property(
     *                 property="errors",
     *                 type="array",
     *                 description="項目別エラーメッセージ",
     *                 @SWG\Items(
     *                     @SWG\Property(property="key", type="array", @SWG\Items(type="string"))
     *                 )
     *             ),
     *         )
     *     )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param ProductImageService $service
     * @param ProductImage $productImage
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImageService $service, ProductImage $productImage)
    {
        DB::transaction(function () use ($productImage) {
            // 保存先の画像を削除
            resolve(ProductImageService::class)->clear($productImage);

            // S3画像も削除されるため物理削除する
            resolve(ProductImageService::class)->destroy($productImage);

        });

        return response()->json(['product_image' => true]);
    }

    /**
     * @SWG\Post(
     *     path="/api/product_images/search",
     *     summary="RESOURCE検索",
     *     description="RESOURCEを検索する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductImages"},
     *
     *     @SWG\Parameter(
     *         name="Authorization",
     *         description="認証トークン",
     *         in="header",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         in="body",
     *         name="Request",
     *         required=true,
     *         type="object",
     *         description="リクエストパラメータ",
     *         @SWG\Schema(
     *             ref="#/definitions/ProductImageSearchRequest"
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_images",
     *                 ref="#/definitions/product_image"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             ),
     *             @SWG\Property(
     *                 property="errors",
     *                 type="array",
     *                 description="項目別エラーメッセージ",
     *                 @SWG\Items(
     *                     @SWG\Property(property="key", type="array", @SWG\Items(type="string"))
     *                 )
     *             ),
     *         )
     *     )
     * )
     *
     * @param ProductImageService $service
     * @param ProductImageSearchRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(ProductImageService $service, ProductImageSearchRequest $request)
    {
        $productImages = $service->search($request);

        return response()->json(compact('productImages'));
    }
}
