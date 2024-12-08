<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Контроллер UserController
 *
 * Обеспечивает управление операциями, связанными с пользователем,
 * включая перевод денег на баланс и получение списка транзакций.
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Перевод денег на баланс пользователя.
     *
     * Метод обрабатывает запрос на перевод указанной суммы денег на баланс текущего пользователя.
     *
     * @param Request $request HTTP-запрос, содержащий сумму перевода в поле "money".
     *
     * @return JsonResponse Ответ API с информацией о новом балансе или ошибке.
     */
    public function transferMoney(Request $request)
    {
        try {
            // Перевод денег через сервис пользователя
            $result = UserService::transferMoney($request->money);

            // Возврат успешного ответа с информацией о новом балансе
            return $this->apiResponse(200, 'success', $result);
        } catch (\Throwable $e) {
            // Обработка ошибок и возврат ответа с кодом 500
            return $this->apiResponse(500, 'error', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Получение списка транзакций пользователя.
     *
     * Метод возвращает список транзакций текущего авторизованного пользователя.
     *
     * @param Request $request HTTP-запрос.
     *
     * @return JsonResponse Ответ API с информацией о транзакциях или ошибке.
     */
    public function getTransactions(Request $request)
    {
        try {
            // Получение транзакций через сервис пользователя
            $result = UserService::getTransactions();

            // Возврат успешного ответа с транзакциями
            return $this->apiResponse(200, 'success', $result);
        } catch (\Throwable $e) {
            // Обработка ошибок и возврат ответа с кодом 500
            return $this->apiResponse(500, 'error', ['message' => $e->getMessage()]);
        }
    }
}
