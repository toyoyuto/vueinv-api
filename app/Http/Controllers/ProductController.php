<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\ORM\Product;
use App\Services\ProductService;
use Throwable;

class ProductController extends BaseController
{
    /**
     * @SWG\Get(
     *     path="/api/products",
     *     summary="RESOURCE一覧",
     *     description="RESOURCE一覧を返す。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Products"},
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
     *                 property="products",
     *                 ref="#/definitions/product"
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
        $products = Product::with(['productCategory', 'productImage'])
            ->orderBy('id')
            ->get();

        return response()->json(compact('products'));
    }

    /**
     * @SWG\Post(
     *     path="/api/products",
     *     summary="RESOURCE登録",
     *     description="RESOURCEを登録する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Products"},
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
     *             ref="#/definitions/ProductStoreRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product",
     *                 type="object",
     *                 ref="#/definitions/product"
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
     * @param ProductService $service
     * @param ProductStoreRequest $request
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductService $service, ProductStoreRequest $request)
    {
        $product = $service->store($request);

        return response()->json(compact('product'));
    }

    /**
     * @SWG\Get(
     *     path="/api/products/{id}",
     *     summary="RESOURCE取得",
     *     description="RESOURCEを取得する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Products"},
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
     *                 property="product",
     *                 type="object",
     *                 ref="#/definitions/product"
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
     * @param Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(compact('product'));
    }

    /**
     * @SWG\Put(
     *     path="/api/products/{id}",
     *     summary="RESOURCE更新",
     *     description="RESOURCEを更新する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Products"},
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
     *             ref="#/definitions/ProductUpdateRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product",
     *                 type="object",
     *                 ref="#/definitions/product"
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
     * @param ProductService $service
     * @param ProductUpdateRequest $request
     * @param Product $product
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductService $service, ProductUpdateRequest $request, Product $product)
    {
        $product = $service->update($request, $product);

        return response()->json(compact('product'));
    }

    /**
     * @SWG\Delete(
     *     path="/api/products/{id}",
     *     summary="RESOURCE削除",
     *     description="RESOURCEを論理削除する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Products"},
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
     *             ref="#/definitions/ProductUpdateRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product",
     *                 type="object",
     *                 ref="#/definitions/ProductResource"
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
     * @param ProductService $service
     * @param Product $product
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductService $service, Product $product)
    {
        $product = $service->destroy($product);

        return response()->json(compact('product'));
    }

    /**
     * @SWG\Post(
     *     path="/api/products/search",
     *     summary="RESOURCE検索",
     *     description="RESOURCEを検索する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Products"},
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
     *             ref="#/definitions/ProductSearchRequest"
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="products",
     *                 ref="#/definitions/product"
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
     * @param ProductService $service
     * @param ProductSearchRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(ProductService $service, ProductSearchRequest $request)
    {
        $products = $service->search($request);

        return response()->json(compact('products'));
    }
}
