<?php

namespace App\Http\Transforms;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class ApiTransform
{
    static $statusCode;
    static $content;
    static $headers = [];

    private static function sendResponse(): JsonResponse
    {
        return response()->json([
            'data' => static::$content,
            'success' => static::$statusCode === 200 || static::$statusCode === 201
        ], static::$statusCode)->withHeaders(static::$headers);
    }

    /**
     * Send JSON response
     * (Status default: 200)
     *
     * @param $content
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    public static function send($content, int $statusCode = 200, array $headers = []): JsonResponse
    {
        static::$statusCode = $statusCode;
        static::$content = $content;
        static::$headers = $headers;
        return static::sendResponse();
    }

    /**
     * Send JSON response OK
     * (Status: 200)
     *
     * @param $content
     * @return JsonResponse
     */
    public static function ok($content): JsonResponse
    {
        static::$statusCode = Response::HTTP_OK;
        static::$content = $content;
        return static::sendResponse();
    }

    /**
     * Send JSON response Internal Server Error exception
     * (Status: 500)
     *
     * @param Exception|Throwable $exception
     * @param string|null $message
     * @return JsonResponse
     */
    public static function internalServerErrorException(Exception $exception, string $message = null): JsonResponse
    {
        static::$statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        static::$content = [
            'message' => $message ?? Lang::get('exception.internal_server_error'),
            'error' => $exception->getMessage()
        ];
        return static::sendResponse();
    }

    /**
     * Send JSON response Bad Request exception
     * (Status: 400)
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    public static function badRequestException(Validator $validator): JsonResponse
    {
        static::$statusCode = Response::HTTP_BAD_REQUEST;
        static::$content = [
            'message' => $validator->errors()->first(),
            'error' => $validator->errors()
        ];
        return static::sendResponse();
    }

    /**
     * Send JSON response Not Found exception
     * (Status: 404)
     *
     * @param string|null $message
     * @return JsonResponse
     */
    public static function notFoundException(string $message = null): JsonResponse
    {
        static::$statusCode = Response::HTTP_NOT_FOUND;
        static::$content = [
            'message' => $message ?? Lang::get('exception.not_found'),
            'error' => 'Not Found'
        ];
        return static::sendResponse();
    }

    /**
     * Send JSON response Forbidden exception
     * (Status: 403)
     *
     * @param string|null $message
     * @return JsonResponse
     */
    public static function forbiddenException(string $message = null): JsonResponse
    {
        static::$statusCode = Response::HTTP_FORBIDDEN;
        static::$content = [
            'message' => $message ?? Lang::get('exception.forbidden'),
            'error' => 'Forbidden'
        ];
        return static::sendResponse();
    }

    /**
     * Send JSON response Conflict exception
     * (Status: 409)
     *
     * @param string|null $message
     * @return JsonResponse
     */
    public static function conflictException(string $message = null): JsonResponse
    {
        static::$statusCode = Response::HTTP_CONFLICT;
        static::$content = [
            'message' => $message ?? Lang::get('exception.conflict'),
            'error' => 'Conflict'
        ];
        return static::sendResponse();
    }

    /**
     * Send JSON response Error exception
     * (Status: 500)
     *
     * @param Exception|Throwable|HttpException $exception
     * @param string|null $message
     * @return JsonResponse
     */
    public static function exception(Exception $exception, string $message = null): JsonResponse
    {
        static::$statusCode = $exception->getStatusCode();
        static::$content = [
            'message' => $message ?? Lang::get('exception.internal_server_error'),
            'error' => $exception->getMessage()
        ];
        return static::sendResponse();
    }
}
