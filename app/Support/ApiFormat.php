<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

/**
 * Формат ответа API «C» (вариант N = 9, 9 mod 3 = 0).
 */
class ApiFormat
{
    /**
     * Подпись ответа: <slug>/<код работы>.
     */
    public static function sign(): string
    {
        return config('lab.slug').'/'.config('lab.code');
    }

    /**
     * Успешный ответ.
     *
     * @param  mixed  $payload  Данные ответа
     * @param  array<string, mixed>|null  $page  Данные пагинации
     */
    public static function success(mixed $payload, int $code = 200, ?array $page = null, array $headers = []): JsonResponse
    {
        $body = [
            'code' => $code,
            'payload' => $payload,
        ];

        if ($page !== null) {
            $body['page'] = $page;
        }

        $body['timestamp'] = now()->toIso8601String();
        $body['sign'] = self::sign();

        return response()->json($body, $code, $headers, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Ответ с ошибкой.
     *
     * @param  array<string, array<int, string>>|null  $invalid  Ошибки валидации по полям
     */
    public static function error(int $code, string $message, ?array $invalid = null): JsonResponse
    {
        $body = [
            'code' => $code,
            'payload' => null,
            'error' => $message,
        ];

        if ($invalid !== null) {
            $body['invalid'] = $invalid;
        }

        $body['timestamp'] = now()->toIso8601String();
        $body['sign'] = self::sign();

        return response()->json($body, $code, [], JSON_UNESCAPED_UNICODE);
    }
}
