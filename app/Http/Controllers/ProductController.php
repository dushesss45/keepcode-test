<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер ProductController
 *
 * Обеспечивает функциональность работы с товарами.
 *
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Отображение доступных товаров.
     *
     * Метод получает список доступных товаров, которые не были зарезервированы,
     * и возвращает их в формате API-ответа.
     *
     * @param Request $request HTTP-запрос.
     *
     * @return JsonResponse Ответ API со списком доступных товаров.
     */
    public function showProducts(Request $request)
    {
        // Получение списка товаров через сервис
        $products = ProductService::getProductList();

        // Формирование успешного ответа
        return $this->apiResponse(200, 'success', $products);
    }
}
