<?php

namespace App\Interfaces;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

/**
 * Интерфейс TransactionStrategy
 *
 * Определяет контракт для реализации различных стратегий обработки транзакций
 * (например, покупка или аренда товара).
 *
 * @package App\Interfaces
 */
interface TransactionStrategy
{
    /**
     * Обрабатывает транзакцию.
     *
     * Этот метод реализуется для выполнения конкретной стратегии обработки транзакции
     * (например, покупка товара или его аренда).
     *
     * @param User $user Пользователь, совершающий транзакцию.
     * @param Product $product Продукт, который является объектом транзакции.
     * @param array $data Дополнительные данные для выполнения транзакции.
     *
     * @return Transaction Транзакция, созданная в результате выполнения стратегии.
     */
    public function process(User $user, Product $product, array $data): Transaction;
}
