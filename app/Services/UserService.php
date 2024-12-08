<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Класс UserService
 *
 * Сервис для работы с пользователями, включая операции с балансом и транзакциями.
 *
 * @package App\Services
 */
class UserService
{
    /**
     * Перевод средств на баланс пользователя.
     *
     * Этот метод добавляет указанную сумму к балансу текущего аутентифицированного пользователя,
     * обновляет баланс в базе данных и возвращает новый баланс.
     *
     * @param float $money Сумма для добавления на баланс.
     *
     * @return array Ассоциативный массив с новым балансом пользователя.
     */
    public static function transferMoney(float $money): array
    {
        // Получение текущего аутентифицированного пользователя
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('Пользователь не авторизован.');
        }

        // Добавление суммы к балансу пользователя
        $user->balance += $money;

        // Сохранение изменений в базе данных
        $user->save();

        // Обновление данных модели пользователя
        $user->refresh();

        // Возврат нового баланса
        return ['new_balance' => $user->balance];
    }

    /**
     * Получение списка транзакций пользователя.
     *
     * Метод возвращает все транзакции текущего аутентифицированного пользователя.
     *
     * @return Collection Коллекция транзакций пользователя.
     * @throws \Exception Если пользователь не авторизован.
     */
    public static function getTransactions(): Collection
    {
        // Получение текущего аутентифицированного пользователя
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('Пользователь не авторизован.');
        }

        // Возврат транзакций пользователя
        return $user->transactions;
    }
}
