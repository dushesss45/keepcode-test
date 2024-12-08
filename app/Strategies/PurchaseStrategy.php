<?php

namespace App\Strategies;

use App\Interfaces\TransactionStrategy;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use Exception;

/**
 * Класс PurchaseStrategy
 *
 * Реализует стратегию покупки товара.
 */
class PurchaseStrategy implements TransactionStrategy
{
    /**
     * Выполняет покупку товара.
     *
     * Проверяет баланс пользователя, списывает стоимость товара
     * и создаёт новую запись о транзакции.
     *
     * @param User $user Пользователь, совершающий покупку.
     * @param Product $product Покупаемый товар.
     * @param array $data Дополнительные данные (не используются в данном методе).
     * @return Transaction Созданная транзакция.
     * @throws Exception Если на балансе недостаточно средств.
     */
    public function process(User $user, Product $product, array $data): Transaction
    {
        // Проверяем, достаточно ли средств на балансе пользователя.
        if ($user->balance < $product->price) {
            throw new Exception("Недостаточно средств для покупки.");
        }

        // Списываем стоимость товара с баланса пользователя.
        $user->balance -= $product->price;
        $user->save();

        // Создаём запись о транзакции покупки.
        return Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => 'purchase',
            'unique_code' => uniqid(), // Генерируем уникальный код для транзакции.
        ]);
    }
}
