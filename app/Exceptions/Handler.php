<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Throwable $exception, $request) {
            if ($request->is('api/*')) {
                if ($exception instanceof NotFoundHttpException) {
                    $statusCode = $exception->getStatusCode() ?: 404;
                    // $message = $exception->getMessage() ? str_replace('/', '//', $exception->getMessage()) : 'Endpoint not found';
                    $message = str_contains($exception->getMessage(), 'The route') ? 'Endpoint not found.' : (str_contains($exception->getMessage(), 'No query results') ? str_replace(']', '', last(explode('\\', $exception->getMessage()))) . ' not found.' : $exception->getMessage());
                    return response()->json([
                        'status' => $statusCode,
                        'message' => $message
                    ], $statusCode);
                } elseif ($exception instanceof ValidationException) {
                    $statusCode = $exception->status ?: 422;
                    return response()->json([
                        'status' => $statusCode,
                        'message' => 'The given data was invalid',
                        'errors' => $exception->errors()
                    ], $statusCode);
                } elseif ($exception instanceof AuthenticationException) {
                    return response()->json([
                        'status' => 401,
                        'message' => $exception->getMessage()
                    ], 401);
                } elseif ($exception instanceof QueryException) {
                    return response()->json([
                        'status' => 500,
                        'message' => $exception->getMessage(),
                    ], 500);
                } elseif ($exception instanceof AuthorizationException || $exception instanceof AccessDeniedHttpException) {
                    $statusCode = $exception->getStatusCode() ?: 403;
                    return response()->json([
                        'status' => $statusCode,
                        'message' => $exception->getMessage(),
                    ], $statusCode);
                } elseif ($exception instanceof BadRequestHttpException || $exception instanceof BadRequestHttpException) {
                    $statusCode = $exception->getStatusCode() ?: 400;
                    $message = $exception->getMessage() ?: 'Invalid request';
                    return response()->json([
                        'status' => $statusCode,
                        'message' => $message
                    ], $statusCode);
                } elseif ($exception instanceof HttpException) {
                    $statusCode = $exception->getStatusCode() ?: 400;
                    $message = $exception->getMessage() ?: 'Invalid request';
                    return response()->json([
                        'status' => $statusCode,
                        'message' => $message
                    ], $statusCode);
                }
                ///check token
                elseif ($exception instanceof TokenExpiredException) {
                    return response([
                        'status' => 403,
                        'message' => 'Token has expired',
                    ], 401);
                } elseif ($exception instanceof TokenInvalidException) {
                    return response([
                        'status' => 401,
                        'message' => 'Token is invalid',
                    ], 401);
                } elseif ($exception instanceof JWTException) {
                    return response([
                        'status' => 500,
                        'message' => 'Something went wrong while processing the token',
                    ], 500);
                }
                //end check token
                elseif ($exception instanceof ErrorException) {
                    $statusCode = $exception->getCode() ?: 500;
                    $message = $exception->getMessage() ?: 'Failed to get service';
                    // $file = $exception->getFile() ?: '';
                    // $line = $exception->getLine() ?: '';
                    return response()->json([
                        'status' => $statusCode,
                        'message' => $message,
                        // 'file' => $file,
                        // 'line' => $line
                    ], $statusCode);
                }
                // elseif ($exception instanceof \Exception) {
                //     dd($exception);
                //     return response()->json([
                //         'code' => $exception->getCode() ?: 500,
                //         'message' => $exception->getMessage()
                //     ], $exception->getCode() ?: 500);
                // }
            }
        });
    }
}
