<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Контроллер AuthController
 *
 * Обеспечивает функциональность регистрации и входа пользователей.
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя.
     *
     * Этот метод обрабатывает запрос на регистрацию нового пользователя.
     * Проверяет входные данные, создает нового пользователя и возвращает токен JWT.
     *
     * @param Request $request HTTP-запрос с данными для регистрации.
     *
     * @return JsonResponse Ответ API с данными о пользователе и токене или сообщением об ошибке.
     */
    public function register(Request $request)
    {
        // Валидация входных данных
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(400, 'error', ['errors' => $validator->errors()]);
        }

        // Создание нового пользователя
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Генерация токена JWT
        $token = JWTAuth::fromUser($user);

        $data = [
            'message' => 'Пользователь успешно зарегистрирован',
            'user'    => $user,
            'token'   => $token,
        ];

        return $this->apiResponse(201, 'success', $data);
    }

    /**
     * Вход пользователя.
     *
     * Этот метод обрабатывает запрос на вход пользователя.
     * Проверяет учетные данные и возвращает токен JWT.
     *
     * @param Request $request HTTP-запрос с учетными данными (email и пароль).
     *
     * @return JsonResponse Ответ API с токеном или сообщением об ошибке.
     */
    public function login(Request $request)
    {
        // Получение учетных данных из запроса
        $credentials = $request->only('email', 'password');

        // Попытка аутентификации пользователя
        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->apiResponse(401, 'error', ['message' => 'Неверные учетные данные']);
        }

        $data = [
            'message' => 'Вход выполнен успешно',
            'token'   => $token,
        ];

        return $this->apiResponse(200, 'success', $data);
    }
}
