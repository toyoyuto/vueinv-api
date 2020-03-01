<?php

namespace App\Validation;

use App\Services\S3ImageService;
use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
    /**
     * 画像ファイルの検証する
     *
     * @param $attribute
     * @param $value
     *
     * @return bool
     */
    public function validateImageBase64($attribute, $value)
    {
        // preg_match()をした検索結果が返ってくる
        $matches = S3ImageService::checkFormatBase64($value);

        // 空の配列が返ってきた場合は正規表現に該当しなかったためバリデーションエラー
        return $matches !== [];
    }
}
