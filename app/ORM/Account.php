<?php

namespace App\ORM;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ORM\Account
 *
 * @property int $id
 * @property int $staff_id スタッフID
 * @property int $store_id 店舗ID
 * @property int $total_product_amount 合計商品金額
 * @property int $tax_amount_1_product_amount 消費税率(8%)適用金額
 * @property int $tax_amount_1 消費税金額(8%)
 * @property int $tax_amount_2_product_amount 消費税率(10%)適用金額
 * @property int $tax_amount_2 消費税金額(10%)
 * @property int $total_tax_amount 合計消費税金額
 * @property int $total_amount 合計金額(税込み)
 * @property int $account_discount_flag 会計割引FLAG
 * @property int $account_discount_amount 会計割引金額
 * @property int $account_amount 会計金額
 * @property int|null $account_method_id 会計方法名ID
 * @property string|null $accounted_at 会計時刻
 * @property int $accounted_flag 会計完了FLAG
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereAccountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereAccountDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereAccountDiscountFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereAccountMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereAccountedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereAccountedFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereTaxAmount1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereTaxAmount1ProductAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereTaxAmount2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereTaxAmount2ProductAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereTotalProductAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereTotalTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
}
