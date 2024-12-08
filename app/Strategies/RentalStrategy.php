<?php

namespace App\Strategies;

use App\Interfaces\TransactionStrategy;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

/**
 * Класс RentalStrategy
 *
 * Реализует стратегию аренды товара.
 */
class RentalStrategy implements TransactionStrategy
{
    /**
     * Выполняет аренду товара.
     *
     * Проверяет возможность аренды (время и баланс), списывает средства
     * и создаёт новую запись о транзакции аренды.
     *
     * @param User $user Пользователь, арендующий товар.
     * @param Product $product Арендуемый товар.
     * @param array $data Дополнительные данные (например, срок аренды).
     * @return Transaction Созданная транзакция аренды.
     * @throws \Exception Если срок аренды превышает 24 часа или недостаточно средств.
     */
    public function process(User $user, Product $product, array $data): Transaction
    {
        // Извлекаем количество часов аренды из данных.
        $hours = $data['hours'];

        // Проверяем, чтобы срок аренды не превышал 24 часа.
        if ($hours > 24) {
            throw new \Exception('Максимальный срок аренды — 24 часа.');
        }

        // Рассчитываем стоимость аренды.
        $cost = $hours * $product->rental;

        // Проверяем, достаточно ли средств на балансе пользователя.
        if ($user->balance < $cost) {
            throw new \Exception('Недостаточно средств для аренды.');
        }

        // Создаём запись о транзакции аренды.
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'type' => 'rental',
            'rental_end_time' => Carbon::now()->addHours($hours), // Устанавливаем дату окончания аренды.
            'unique_code' => uniqid(), // Генерируем уникальный код.
        ]);

        // Списываем стоимость аренды с баланса пользователя.
        $user->balance -= $cost;
        $user->save();

        // Возвращаем обновлённую запись транзакции.
        return $transaction;
    }
}
