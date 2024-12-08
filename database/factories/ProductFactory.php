<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * Фабрика для генерации данных модели Product.
 *
 * Класс генерирует тестовые данные для модели Product, включая случайные
 * значения для названия, цены и стоимости аренды.
 *
 * @package Database\Factories
 */
class ProductFactory extends Factory
{
    /**
     * @var string Модель, связанная с фабрикой.
     */
    protected $model = Product::class;

    /**
     * Определяет данные по умолчанию для модели Product.
     *
     * @return array Сгенерированные данные для модели Product.
     */
    public function definition(): array
    {
        // Генерация случайной цены в пределах от 1000 до 10000
        $price = $this->faker->randomFloat(2, 1000, 10000);

        return [
            /**
             * Название продукта.
             * Генерируется случайное название из нескольких слов, каждое с заглавной буквы.
             * Например: "Bright Sky Lamp".
             */
            'name'       => ucfirst(implode(' ', $this->faker->words())),

            /**
             * Цена продукта.
             * Случайное число с двумя знаками после запятой.
             */
            'price'      => $price,

            /**
             * Стоимость аренды продукта.
             * Случайное число, не превышающее 1/4 от общей цены.
             */
            'rental'     => $this->faker->randomFloat(2, 1, $price / 4),

            /**
             * Дата создания записи.
             * Устанавливается текущая дата и время.
             */
            'created_at' => Carbon::now(),

            /**
             * Дата последнего обновления записи.
             * Устанавливается текущая дата и время.
             */
            'updated_at' => Carbon::now(),
        ];
    }
}
