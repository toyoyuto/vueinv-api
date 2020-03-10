<?php

namespace App\Services;

use Storage;
use Log;

class S3ImageService
{
    /**
     * 画像をS3に保存
     *
     * @param string $path 格納するpath(ファイル名含む)
     * @param string $base64 base64でエンコード済みの画像データ
     *
     * @return void
     */
    public function saveImage(string $path, string $base64): void
    {
        // 画像の実データをデコードする
        $data = base64_decode($base64, true);
        // 保存
        Storage::disk('s3')->put($path, $data);
    }
    
    /**
     * S3から画像を削除
     *
     * @param string $path
     *
     * @return void
     */
    public function removeImage(string $path): void
    {
        // ファイルが無ければ何もしない
        if (!Storage::disk('s3')->exists($path)) {
            return;
        }

        // 削除
        Storage::disk('s3')->delete($path);
    }

        
    /**
     * S3からディレクトリごと削除する
     *
     * @param string $directory
     *
     * @return void
     */
    public function removeDirectory(string $directory): void
    {
        // ファイルが無ければ何もしない
        if (!Storage::disk('s3')->files($directory)) {
            return;
        }

        // 削除
        Storage::disk('s3')->deleteDirectory($directory);
    }

    /**
     * S3から画像データをbase64形式で取得
     *
     * @param string $path
     *
     * @return string 埋込base64形式
     */
    public function getImage(string $path): string
    {
        $storage = Storage::disk('s3');

        // ファイルが無ければ空文字
        if (!$storage->exists($path)) {
            return '';
        }

        $mime_type = $storage->mimeType($path);
        $base64    = base64_encode($storage->get($path));

        return "data:{$mime_type};base64,{$base64}";
    }

    /**
     * S3に登録するbase64データのフォーマットをチェックする
     *
     * @param string $base64
     *
     * @return array $matches
     */
    public static function checkFormatBase64(string $base64): array
    {
        // POSTでBASE64のデータを渡すと+がスペースに置換されるため戻す
        $base64 = str_replace(' ', '+', $base64);

        // 正規表現のチェック＆base64の実データを抜き出す
        preg_match('@^data:image/(jpg|jpeg);base64,(.*)$@', $base64, $matches);

        return $matches;
    }

    /**
     * S3に登録されている画像のURLを取得する
     *
     * @param string $path
     *
     * @return string
     */
    public function getUrl(string $path): string
    {
        return Storage::disk('s3')
            ->url($path);
    }

     /**
     * 画像ファイルに拡張子を付与する
     *
     * @param string $file_name
     *
     * @return string
     */
    public static function addImageExtension(string $file_name): string
    {
        return "{$file_name}.jpg";
    }
}
