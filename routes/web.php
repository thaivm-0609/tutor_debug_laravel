<?php

use App\Http\Controllers\TestController;
use App\Models\Test;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/performances', function () { //check request chạy chậm
    $tests = Test::limit(50)->get();

    usleep(10000000); //đặt sleep để request chờ 10s (10,000,000 micro giây)

    return response()->json([
        'tests' => $tests
    ])
});

Route::get('/debug/tests/{id}', function ($id) { //lỗi 500 hoặc 404
    $test = Test::find($id);
    if (!$test) {
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    return response()->json([
        'name' => $test->name,
        'type' => $test->type,
        'duration'> $test->duration,
    ]);
});

Route::get('/tests', [TestController::class, 'index']);
