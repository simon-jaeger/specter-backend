<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler {
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
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   *
   * @return void
   */
  public function register() {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  // flatten validation errors, only return first for each field
  protected function invalidJson($request, ValidationException $exception) {
    return response()->json([
      'message' => $exception->getMessage(),
      'errors' => collect($exception->errors())->map(fn($x) => $x[0])
    ], $exception->status);
  }
}
