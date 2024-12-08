<?php

namespace App\Models;

use App\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Класс Product
 *
 * Представляет товар, который может быть арендован или куплен.
 *
 * @package App\Models
 *
 * @property int $id Уникальный идентификатор товара
 * @property string $name Название товара
 * @property float $price Стоимость товара при покупке
 * @property float $rental Стоимость аренды товара за единицу времени
 * @property Carbon|null $created_at Время создания товара
 * @property Carbon|null $updated_at Время последнего обновления товара
 *
 * @method static Builder|Product notReserved() Скоуп для получения товаров, которые не зарезервированы
 */
class Product extends Model
{
    use HasFactory, TransactionTrait;

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'rental',
    ];

    /**
     * Скоуп для получения товаров, которые не зарезервированы,
     * проверяя статус их транзакций.
     *
     * @param Builder $query Запрос к базе данных
     * @return Builder
     */
    public function scopeNotReserved($query): Builder
    {
        return $query->whereDoesntHave('transactions', function ($q) {
            $q->where('type', 'rental')
                ->orWhere('type', 'purchase');
        });
    }
}
