<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Трейт ProductTrait
 *
 * Добавляет связь между текущей моделью и моделью Product.
 */
trait ProductTrait
{
    /**
     * Связь "принадлежит" (BelongsTo) с моделью Product.
     *
     * Указывает, что текущая модель связана с одной записью из таблицы `products`.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
