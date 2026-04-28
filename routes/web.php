<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

Route::get('/', [HomeController::class, 'index']);
Route::get('/json', [HomeController::class, 'json']);
Route::get('/cases/{slug}', [CaseController::class, 'show'])->where('slug', '[a-z0-9\-]+');

Route::get('/contact', [ContactController::class, 'show']);
Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:5,1');

if (app()->environment('local')) {
    Route::get('/__dev/errors', function () {
        $codes = [401, 403, 404, 419, 500, 503];
        $links = collect($codes)->map(fn ($c) => [
            'code' => $c,
            'url'  => "/__dev/errors/{$c}",
        ])->all();

        return response()->view('errors._dev-index', ['links' => $links]);
    });

    Route::get('/__dev/errors/{code}', function (string $code) {
        $allowed = [401, 403, 404, 419, 500, 503];
        $status = (int) $code;
        abort_unless(in_array($status, $allowed, true), 404);

        $exception = $status === 503
            ? new ServiceUnavailableHttpException(120, 'Плановое обслуживание (preview)')
            : new HttpException($status);

        $data = ['__devPreview' => true, 'exception' => $exception];
        $headers = method_exists($exception, 'getHeaders') ? $exception->getHeaders() : [];

        return response()->view("errors.{$code}", $data, $status, $headers);
    })->where('code', '\d{3}');
}
