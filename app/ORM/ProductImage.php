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
        'url'
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

}
