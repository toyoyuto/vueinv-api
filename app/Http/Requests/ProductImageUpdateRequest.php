<?php

namespace App\Http\Requests;

/**
 * @SWG\Definition(definition="ProductImageUpdateRequest", type="object")
 */

class ProductImageUpdateRequest extends BaseRequest
{
    /**
     * @SWG\Property(property="product_id",description="商品ID", type="integer")
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
            'product_id'   => ['required', 'integer'],
            'image'        => ['required', 'string', 'image_base64'],  // 画像ファイルの拡張子はjpg,jpeg
        ];
    }

    public function attributes()
    {
        return [
            'image' => '商品画像'
        ];
    }
}
