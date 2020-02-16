<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\Staff
 *
 * @property int $id
 * @property string $staff_cd スタッフCD
 * @property string $name スタッフ名
 * @property string $email メールアドレス
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Staff onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff whereStaffCd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Staff withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\Staff withoutTrashed()
 * @mixin \Eloquent
 */
class Staff extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'staffs';

    protected $fillable = [
        'staff_cd',
        'name',
        'email',
    ];
}
