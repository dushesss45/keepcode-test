<?php

namespace App\Traits;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Трейт TransactionTrait
 *
 * Добавляет связь между текущей моделью и моделью Transaction.
 */
trait TransactionTrait
{
    /**
     * Связь "имеет много" (HasMany) с моделью Transaction.
     *
     * Указывает, что текущая модель может иметь множество связанных записей из таблицы `transactions`.
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
