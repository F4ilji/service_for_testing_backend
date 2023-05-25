<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\test\TestController;
use App\Http\Controllers\api\quest\QuestController;
use App\Http\Controllers\api\answer\AnswerController;
use App\Http\Controllers\api\quest\TypeQuestController;
use App\Http\Controllers\api\session\SessionController;
use App\Http\Controllers\api\category\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'Is_admin'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');




// Роуты для тестов
Route::get('/tests', [TestController::class, 'index']);
Route::get('/tests/{id}', [TestController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::put('/tests/{id}', [TestController::class, 'update']);
    Route::post('/tests', [TestController::class, 'store']);
    Route::delete('/tests/{id}', [TestController::class, 'destroy']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/tests/{test_id}/questions', [QuestController::class, 'index'])->middleware(['auth:sanctum', 'CheckFinishedSession']);
Route::get('/session', [SessionController::class, 'getUserSession'])->middleware(['auth:sanctum', 'CheckFinishedSession']);
Route::get('/sessions', [SessionController::class, 'getUserSessions'])->middleware(['auth:sanctum']);
Route::post('/sessions/{test_id}', [SessionController::class, 'startUserSession'])->middleware(['auth:sanctum', 'CheckUnfinishedSession']);
Route::patch('/sessions/{test_id}', [SessionController::class, 'finishUserSession'])->middleware(['auth:sanctum', 'CheckFinishedSession']);
Route::post('/sessions/{test_id}/answers', [SessionController::class, 'addUserAnswer'])->middleware(['auth:sanctum', 'CheckFinishedSession']);

Route::group(['middleware' => ['auth:sanctum', 'Is_admin'], 'prefix' => 'admin'], function() {
    Route::get('/tests/{test_id}/questions', [QuestController::class, 'getQuestions']);
    Route::get('/tests/{test_id}/questions/{id}', [QuestController::class, 'show']);
    Route::post('/tests/{test_id}/questions', [QuestController::class, 'store']);
    Route::put('/tests/{test_id}/questions/{id}', [QuestController::class, 'update']);
    Route::delete('/tests/{test_id}/questions/{id}', [QuestController::class, 'destroy']);
    Route::get('/tests/{test_id}/questions/{question_id}/answers', [AnswerController::class, 'index']);
    Route::post('/tests/{test_id}/questions/{question_id}/answers', [AnswerController::class, 'store']);
    Route::put('/tests/{test_id}/questions/{question_id}/answers/{id}', [AnswerController::class, 'update']);
    Route::delete('/tests/{test_id}/questions/{question_id}/answers/{id}', [AnswerController::class, 'destroy']);
    Route::put('/tests/{id}', [TestController::class, 'update']);
    Route::post('/tests', [TestController::class, 'store']);
    Route::delete('/tests/{id}', [TestController::class, 'destroy']);
});
// Роуты для вопросов



// Роуты для ответов



