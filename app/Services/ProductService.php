<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Класс ProductService
 *
 * Сервис для работы с товарами.
 *
 * @package App\Services
 */
class ProductService
{
    /**
     * Получить список доступных товаров, которые не зарезервированы.
     *
     * @return Collection|array Коллекция или массив доступных товаров
     */
    public static function getProductList(): Collection|array
    {
        return Product::notReserved()->get();
    }
}
