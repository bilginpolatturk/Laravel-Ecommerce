<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function handleException($request, Exception $exception)
    {
        if($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404',compact('exception'),404);
        }

        if($exception instanceof ModelNotFoundException) {
            return response()->view('errors.404',compact('exception'),404);
        }
    }

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function(Exception $e, $request) {
            return $this->handleException($request, $e);
        });
    }

    protected  function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => 'Unauthenticated'],401)
            : redirect()->guest(route('kullanici.oturumac'));
    }
}
