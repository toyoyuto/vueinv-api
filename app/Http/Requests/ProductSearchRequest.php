<?php

namespace App\Http\Requests;

/**
 * @SWG\Definition(definition="ProductSearchRequest", type="object")
 */
class ProductSearchRequest extends BaseRequest
{
    /**
     * @SWG\Property(property="id",description="ID", type="integer")
     * @SWG\Property(property="product_cd",description="商品CD", type="string")
     * @SWG\Property(property="name",description="商品名", type="string")
     * @SWG\Property(property="product_category_id",description="商品カテゴリーID", type="integer")
     * @SWG\Property(property="without_tax_sell_price_first",description="販売単価(税抜き)下限", type="integer")
     * @SWG\Property(property="without_tax_sell_price_last",description="販売単価(税抜き)上限", type="integer")
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
            'id'                           => ['nullable', 'integer'],
            'product_cd'                   => ['nullable'],
            'name'                         => ['nullable', 'max:255'],
            'product_category_id'          => ['nullable', 'integer'],
            'without_tax_sell_price_first' => ['nullable', 'integer'],
            'without_tax_sell_price_last'  => ['nullable', 'integer'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => '商品名',
        ];
    }
}
