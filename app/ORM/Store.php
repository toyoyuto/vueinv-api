<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\Store
 *
 * @property int $id
 * @property string $name 店舗名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Store onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Store withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Store withoutTrashed()
 * @mixin \Eloquent
 */
class Store extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'stores';

    protected $fillable = [
        'name',
    ];
}
