<?php

namespace App\Http\Controllers;

use App\Factories\TransactionStrategyFactory;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер TransactionController
 *
 * Обеспечивает функциональность обработки транзакций (покупка, аренда и т.д.).
 *
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{
    /**
     * Обработка транзакции.
     *
     * Метод обрабатывает транзакцию (например, покупку или аренду товара)
     * с использованием соответствующей стратегии, создаваемой фабрикой.
     *
     * @param Request $request HTTP-запрос, содержащий данные для обработки транзакции.
     * @param string $action Действие, которое нужно выполнить (например, "purchase", "rental").
     * @param int $productId Идентификатор товара, для которого выполняется транзакция.
     *
     * @return JsonResponse Ответ API с результатом транзакции.
     */
    public function processTransaction(Request $request, string $action, int $productId)
    {
        try {
            // Создание стратегии для выполнения действия
            $strategy = TransactionStrategyFactory::create($action);

            // Получение данных из запроса
            $data = $request->all();

            // Выполнение стратегии обработки транзакции
            $result = $strategy->process($request->user(), Product::findOrFail($productId), $data);

            // Возвращение успешного ответа
            return $this->apiResponse(200, 'success', $result);
        } catch (\Throwable $e) {
            // Обработка ошибок и возврат соответствующего ответа
            return $this->apiResponse(400, 'error', $e->getMessage());
        }
    }
}
