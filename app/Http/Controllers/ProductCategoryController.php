<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategorySearchRequest;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\ORM\ProductCategory;
use App\Services\ProductCategoryService;
use Throwable;

class ProductCategoryController extends BaseController
{
    /**
     * @SWG\Get(
     *     path="/api/product_categories",
     *     summary="RESOURCE一覧",
     *     description="RESOURCE一覧を返す。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductCategories"},
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
     *                 property="product_categories",
     *                 ref="#/definitions/product_category"
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
        $productCategorys = ProductCategory::orderBy('id')->get();

        return response()->json(compact('productCategorys'));
    }

    /**
     * @SWG\Post(
     *     path="/api/product_categories",
     *     summary="RESOURCE登録",
     *     description="RESOURCEを登録する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductCategories"},
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
     *             ref="#/definitions/ProductCategoryStoreRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_category",
     *                 type="object",
     *                 ref="#/definitions/product_category"
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
     * @param ProductCategoryService $service
     * @param ProductCategoryStoreRequest $request
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryService $service, ProductCategoryStoreRequest $request)
    {
        $productCategory = $service->store($request);

        return response()->json(compact('productCategory'));
    }

    /**
     * @SWG\Get(
     *     path="/api/product_categories/{id}",
     *     summary="RESOURCE取得",
     *     description="RESOURCEを取得する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductCategories"},
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
     *                 property="product_category",
     *                 type="object",
     *                 ref="#/definitions/product_category"
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
     * @param ProductCategory $productCategory
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        return response()->json(compact('productCategory'));
    }

    /**
     * @SWG\Put(
     *     path="/api/product_categories/{id}",
     *     summary="RESOURCE更新",
     *     description="RESOURCEを更新する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductCategories"},
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
     *             ref="#/definitions/ProductCategoryUpdateRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_category",
     *                 type="object",
     *                 ref="#/definitions/product_category"
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
     * @param ProductCategoryService $service
     * @param ProductCategoryUpdateRequest $request
     * @param ProductCategory $productCategory
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryService $service, ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        $productCategory = $service->update($request, $productCategory);

        return response()->json(compact('productCategory'));
    }

    /**
     * @SWG\Delete(
     *     path="/api/product_categories/{id}",
     *     summary="RESOURCE削除",
     *     description="RESOURCEを論理削除する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductCategories"},
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
     *             ref="#/definitions/ProductCategoryUpdateRequest"
     *         )
     *     ),
     *
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_category",
     *                 type="object",
     *                 ref="#/definitions/ProductCategoryResource"
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
     * @param ProductCategoryService $service
     * @param ProductCategory $productCategory
     *
     * @throws Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategoryService $service, ProductCategory $productCategory)
    {
        $productCategory = $service->destroy($productCategory);

        return response()->json(compact('productCategory'));
    }

    /**
     * @SWG\Post(
     *     path="/api/product_categories/search",
     *     summary="RESOURCE検索",
     *     description="RESOURCEを検索する。",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"ProductCategories"},
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
     *             ref="#/definitions/ProductCategorySearchRequest"
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product_categories",
     *                 ref="#/definitions/product_category"
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
     * @param ProductCategoryService $service
     * @param ProductCategorySearchRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(ProductCategoryService $service, ProductCategorySearchRequest $request)
    {
        $productCategorys = $service->search($request);

        return response()->json(compact('productCategorys'));
    }
}
