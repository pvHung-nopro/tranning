<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use App\Exceptions\Server\SystemException;
use App\Exceptions\Client\ClientException;
use App\Facades\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (SystemException $e) {
            return Response::failure($e->getMessage(), [], $e->getCode(), $e->getCode());
        });

        $this->renderable(function (ClientException $e) {
            return Response::failure($e->getMessage(), [], $e->getCode(), $e->getCode());
        });

        $this->renderable(function (ValidationException $e) {
            $errors = array_values($e->errors());
            try {
                $keys = array_keys($e->errors());
                $optional = [
                    'validation_key' => $keys[0] . '.' . strtolower(array_keys($e->validator->failed()[$keys[0]])[0]),
                ];
            } catch (\Exception $e) {
                $optional = [];
            }
            return Response::failure(
                $errors[0][0],
                $optional,
                422,
                422
            );
        });
    }
}
