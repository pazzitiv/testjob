<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {

        });
    }

    public function render($request, Throwable $exception)
    {
        $e = parent::render($request, $exception);

        if($e->exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
            return response()->json(['error' => 'Неверный токен авторизации'], 401);
        } elseif ($e->exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(['error' => 'Время действия сессии истекло'], 401);
        } elseif ($e->exception instanceof HttpException) {
            return response()->json(['error' => $e->status()], $e->getStatusCode());
        } elseif ($exception instanceof AuthenticationException) {
            return $e;
        } else {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
