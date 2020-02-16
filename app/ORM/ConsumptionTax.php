<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ORM\ConsumptionTax
 *
 * @property int $id
 * @property int $rate 消費税率
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ConsumptionTax onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\ConsumptionTax whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ConsumptionTax withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ORM\ConsumptionTax withoutTrashed()
 * @mixin \Eloquent
 */
class ConsumptionTax extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'consumption_taxs';

    protected $fillable = [
        'rate',
    ];
}
