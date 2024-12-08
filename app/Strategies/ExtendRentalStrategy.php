<?php

namespace App\Strategies;

use App\Interfaces\TransactionStrategy;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

/**
 * Класс ExtendRentalStrategy
 *
 * Реализует стратегию продления аренды для транзакций.
 */
class ExtendRentalStrategy implements TransactionStrategy
{
    /**
     * Обрабатывает продление аренды.
     *
     * Проверяет условия продления, включая баланс пользователя, оставшееся время аренды,
     * и обновляет информацию о транзакции.
     *
     * @param User $user Пользователь, выполняющий продление аренды.
     * @param Product $product Продукт, который арендуется.
     * @param array $data Дополнительные данные (например, количество часов).
     * @return Transaction Обновлённая транзакция.
     * @throws \Exception Если условия продления не выполнены.
     */
    public function process(User $user, Product $product, array $data): Transaction
    {
        // Находим активную транзакцию аренды для данного пользователя и товара.
        $transaction = Transaction::where('id', $data['transaction_id'])
            ->where('user_id', $user->id)
            ->where('type', 'rental')
            ->firstOrFail();

        // Количество часов для продления.
        $hours = $data['hours'];

        // Вычисляем оставшиеся часы до конца максимального срока аренды.
        $remainingHours = 24 - Carbon::now()->diffInHours(Carbon::createFromTimestamp($transaction->rental_end_time));

        // Проверяем, превышает ли продление оставшееся время.
        if ($hours > $remainingHours) {
            throw new \Exception('Продление превышает допустимый срок аренды.');
        }

        // Рассчитываем стоимость продления.
        $cost = $hours * $transaction->product->rental;

        // Проверяем баланс пользователя.
        if ($user->balance < $cost) {
            throw new \Exception('Недостаточно средств для продления аренды.');
        }

        // Обновляем время окончания аренды.
        $transaction->rental_end_time = Carbon::createFromTimestamp($transaction->rental_end_time)
            ->addHours($hours)
            ->toDateTimeString();
        $transaction->save();

        // Списываем средства с баланса пользователя.
        $user->balance -= $cost;
        $user->save();

        // Возвращаем обновлённую транзакцию.
        return $transaction->refresh();
    }
}
