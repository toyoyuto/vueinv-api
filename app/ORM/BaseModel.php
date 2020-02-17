<?php

namespace App\ORM;

use App\Traits\EscapeMysqlSpecialChars;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\BaseModel
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\BaseModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereForwardMatch($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereInclude($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereMatch($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereRange($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\BaseModel whereSame($array)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\BaseModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\BaseModel withoutTrashed()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    use SoftDeletes;
    use EscapeMysqlSpecialChars;

    /**
     * fill可能な項目
     *
     * @var array
     */
    // protected $fillable = [];

    /**
     * fillしない項目
     * TODO: 最終的には各モデルでfillableを設定する
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'q', // nginxの設定により送られてくるため除外
    ];

    /**
     * jsonに出力しない項目
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    /**
     * Carbonで取得する項目
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 完全一致を一括設定
     *
     * @param $query
     * @param $array
     */
    public function scopeWhereSame($query, $array): void
    {
        foreach ($array as $key => $value) {
            if (!strlen($value)) {
                continue;
            }
            $query->where($key, $value);
        }
    }

    /**
     * 部分一致を一括設定
     *
     * @param $query
     * @param $array
     */
    public function scopeWhereMatch($query, $array): void
    {
        foreach ($array as $key => $value) {
            if (!strlen($value)) {
                continue;
            }
            $query->where($key, 'like', '%' . $this->escapeForLikeQuery($value) . '%');
        }
    }

    /**
     * 前方一致を一括設定
     *
     * @param $query
     * @param $array
     */
    public function scopeWhereForwardMatch($query, $array): void
    {
        foreach ($array as $key => $value) {
            if (!strlen($value)) {
                continue;
            }
            $query->where($key, 'like', $this->escapeForLikeQuery($value) . '%');
        }
    }

    /**
     * 包含を一括設定
     *
     * @param $query
     * @param $array
     */
    public function scopeWhereInclude($query, $array): void
    {
        foreach ($array as $key => $value) {
            if (!$value) {
                continue;
            }
            $query->whereIn($key, $value);
        }
    }

    /**
     * 範囲検索を一括指定
     *
     * @param $query
     * @param $array
     */
    public function scopeWhereRange($query, $array): void
    {
        foreach ($array as $key => $value) {
            if (!$value) {
                continue;
            }
            // first、lastは包含範囲
            if (array_has($value, 'first') && strlen($value['first'])) {
                $query->where($key, '>=', $value['first']);
            }

            if (array_has($value, 'last') && strlen($value['last'])) {
                $query->where($key, '<=', $value['last']);
            }
            // begin、endは包含・排他範囲
            if (array_has($value, 'begin') && strlen($value['begin'])) {
                $query->where($key, '>=', $value['begin']);
            }

            if (array_has($value, 'end') && strlen($value['end'])) {
                $query->where($key, '<', $value['end']);
            }
        }
    }
}
