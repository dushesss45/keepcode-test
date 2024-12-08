<?php

namespace App\Models;

use App\Traits\TransactionTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Класс User
 *
 * Представляет модель пользователя приложения.
 *
 * @package App\Models
 *
 * @property int $id Уникальный идентификатор пользователя
 * @property string $name Имя пользователя
 * @property string $email Электронная почта пользователя
 * @property string $password Пароль пользователя (хранится в зашифрованном виде)
 * @property float $balance Баланс пользователя
 * @property \Illuminate\Support\Carbon|null $created_at Время создания пользователя
 * @property \Illuminate\Support\Carbon|null $updated_at Время последнего обновления пользователя
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory, HasApiTokens, TransactionTrait;

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance'
    ];

    /**
     * Атрибуты, которые скрываются при преобразовании модели в массив или JSON.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Получить идентификатор JWT для пользователя.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Получить дополнительные пользовательские данные для токена JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
