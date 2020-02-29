<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductImage extends BaseModel
{
    use SoftDeletes;

    protected $table = 'product_images';

     /** JSONに含めるアクセサ */
     protected $appends = [
        'url',
        'base64'
    ];

    protected $fillable = [
        'product_id',
        'path'
    ];

    /**
     * アクセサ - url
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::disk('s3')->url($this->attributes['path']);
    }

    /**
     * アクセサ - base64
     * @return string
     */
    public function getBase64Attribute()
    {
        $storage = Storage::disk('s3');
        $mime_type = $storage->mimeType($this->attributes['path']);
        $base64 = base64_encode($storage->get($this->attributes['path']));
        return "data:{$mime_type};base64,{$base64}";
    }

}
