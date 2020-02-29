<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageSearchRequest;
use App\Http\Requests\ProductImageStoreRequest;
use App\Http\Requests\ProductImageUpdateRequest;
use App\ORM\ProductImage;
use App\Services\ProductImageService;
use Throwable;

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
     * @param ProductImageService $service
     * @param ProductImageStoreRequest $request
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductImageService $service, ProductImageStoreRequest $request)
    {
        $productImage = $service->store($request);

        return response()->json(compact('productImage'));
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
    public function update(ProductImageService $service, ProductImageUpdateRequest $request, ProductImage $productImage)
    {
        $productImage = $service->update($request, $productImage);

        return response()->json(compact('productImage'));
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
        $productImage = $service->destroy($productImage);

        return response()->json(compact('productImage'));
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
