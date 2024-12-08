<?php

namespace App\Factories;

use App\Interfaces\TransactionStrategy;
use App\Strategies\ExtendRentalStrategy;
use App\Strategies\PurchaseStrategy;
use App\Strategies\RentalStrategy;

/**
 * Фабрика для создания стратегий транзакций.
 *
 * Класс отвечает за создание экземпляров стратегий на основе типа транзакции.
 */
class TransactionStrategyFactory
{
    /**
     * Создает экземпляр стратегии транзакции.
     *
     * @param string $type Тип транзакции ('purchase', 'rent', 'extend').
     * @return TransactionStrategy Реализация стратегии транзакции.
     *
     * @throws \InvalidArgumentException Если тип транзакции неизвестен.
     */
    public static function create(string $type): TransactionStrategy
    {
        return match ($type) {
            'purchase' => new PurchaseStrategy(),
            'rent' => new RentalStrategy(),
            'extend' => new ExtendRentalStrategy(),
            default => throw new \InvalidArgumentException("Unknown transaction type: {$type}")
        };
    }
}
