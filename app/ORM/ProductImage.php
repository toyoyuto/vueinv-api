<?php

namespace App\ORM;

use App\Services\S3ImageService;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\ProductImage
 *
 * @property int $id
 * @property int $product_id 商品ID
 * @property string $path S3の格納先フルパス
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $base64
 * @property-read string $url
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ProductImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereForwardMatch($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereInclude($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereMatch($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereRange($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereSame($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ProductImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ProductImage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ProductImage withoutTrashed()
 * @mixin \Eloquent
 */
class ProductImage extends BaseModel
{
    use SoftDeletes;

    protected $table = 'product_images';

    /** JSONに含めるアクセサ */
    protected $appends = [
        'url',
        'base64',
    ];

    protected $fillable = [
        'product_id',
        'path',
    ];

    /**
     * アクセサ - url
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return resolve(S3ImageService::class)
            ->getUrl($this->attributes['path']);
    }

    /**
     * アクセサ - base64
     *
     * @return string
     */
    public function getBase64Attribute()
    {
        return resolve(S3ImageService::class)
            ->getImage($this->attributes['path']);
    }
}
