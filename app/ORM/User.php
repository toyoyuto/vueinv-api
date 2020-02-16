<?php

namespace App\ORM;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\ORM\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ORM\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
