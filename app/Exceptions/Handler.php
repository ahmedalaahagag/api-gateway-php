<?php

namespace App\Exceptions;

use App\Traits\ApiResponder;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ApiResponder;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof  HttpException){
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];
            return $this->errorResponse($message, $code);
        }
        if($exception instanceof ModelNotFoundException){
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("Dose exist instance of {$model} with this id", Response::HTTP_NOT_FOUND);
        }
        if($exception instanceof AuthorizationException){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
        }
        if($exception instanceof AuthenticationException){
            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
        if($exception instanceof ValidationException){
            $errors = $exception->errors();
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if($exception instanceof ClientException){
            $message = $exception->getResponse()->getBody();
            $code = $exception->getCode();
            return $this->errorMessage($message, $code);
        }
        if(env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }
        return $this->errorResponse('unexpected error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
