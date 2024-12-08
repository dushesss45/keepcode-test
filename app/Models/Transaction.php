<?php

namespace App\Models;

use App\Traits\ProductTrait;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Класс Transaction
 *
 * Представляет транзакцию, связанную с покупкой или арендой товара.
 *
 * @package App\Models
 *
 * @property int $id Уникальный идентификатор транзакции
 * @property string $type Тип транзакции (purchase или rental)
 * @property int $product_id Идентификатор связанного товара
 * @property int $user_id Идентификатор связанного пользователя
 * @property int|null $rental_end_time Время окончания аренды (в формате timestamp)
 * @property string|null $unique_code Уникальный код, связанный с транзакцией
 * @property Carbon|null $created_at Время создания транзакции
 * @property Carbon|null $updated_at Время последнего обновления транзакции
 */
class Transaction extends Model
{
    use HasFactory, ProductTrait, UserTrait;

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'product_id',
        'user_id',
        'rental_end_time',
        'unique_code',
    ];

    /**
     * Приведение типов для определенных атрибутов.
     *
     * @var array
     */
    protected $casts = [
        'rental_end_time' => 'timestamp',
        'unique_code'     => 'string',
    ];
}
