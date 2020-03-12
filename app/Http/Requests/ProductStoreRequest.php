<?php

namespace App\Http\Requests;

/**
 * @SWG\Definition(definition="ProductStoreRequest", type="object")
 */
class ProductStoreRequest extends BaseRequest
{
    /**
     * @SWG\Property(property="product_cd",description="商品CD", type="string")
     * @SWG\Property(property="name",description="商品名", type="string")
     * @SWG\Property(property="product_category_id",description="商品カテゴリーID", type="integer")
     * @SWG\Property(property="without_tax_sell_price_first",description="販売単価(税抜き)", type="integer")
     * @SWG\Property(property="image",description="商品画像base64", type="string")
     */

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_cd'                   => ['required'],
            'name'                         => ['required', 'max:255'],
            'product_category_id'          => ['required', 'integer'],
            'without_tax_sell_price'       => ['required', 'integer'],
            'image'         => ['required', 'string', 'image_base64'], // 画像ファイルの拡張子はjpg,jpeg
        ];
    }

    public function attributes()
    {
        return [
            'name' => '商品名',
            'image' => '商品画像'
        ];
    }
}
