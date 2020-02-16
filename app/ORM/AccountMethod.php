<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\AccountMethod
 *
 * @property int $id
 * @property string $name 会計方法名
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\AccountMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountMethod withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\AccountMethod withoutTrashed()
 * @mixin \Eloquent
 */
class AccountMethod extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'account_methods';

    protected $fillable = [
        'name',
    ];
}
