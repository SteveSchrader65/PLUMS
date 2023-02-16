<?php

use App\Http\Controllers\API\APIFallbackController;
use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\CountryAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AnswerAPIController;
use App\Http\Controllers\API\FieldAPIController;
use App\Http\Controllers\API\LevelAPIController;
use App\Http\Controllers\API\QuestionAPIController;
use App\Http\Controllers\API\QuizAPIController;
use App\Http\Controllers\API\SkillAPIController;
use App\Http\Controllers\API\UserAPIController;
use Spatie\Health\Http\Controllers\HealthCheckJsonResultsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthAPIController::class, 'login']);
Route::post('register', [AuthAPIController::class,'register']);

Route::get("answers", [AnswerAPIController::class, 'index']);
Route::get("fields", [FieldAPIController::class, 'index']);
Route::get("levels", [LevelAPIController::class, 'index']);
Route::get("questions", [QuestionAPIController::class, 'index']);
Route::get("quizzes", [QuizAPIController::class, 'index']);
Route::get("skills", [SkillAPIController::class, 'index']);
Route::get("users", [UserAPIController::class, 'index']);
Route::get("countries", [CountryAPIController::class, 'index']);

Route::get("answers/search", [AnswerAPIController::class, 'search']);
Route::get("fields/search", [FieldAPIController::class, 'search']);
Route::get("levels/search", [LevelAPIController::class, 'search']);
Route::get("questions/search", [QuestionAPIController::class, 'search']);
Route::get("quizzes/search", [QuizAPIController::class, 'search']);
Route::get("skills/search", [SkillAPIController::class, 'search']);
Route::get("users/search", [UserAPIController::class, 'search']);
Route::get("countries/search", [CountryAPIController::class, 'search']);

Route::get("answers/{id}", [AnswerAPIController::class, 'show']);
Route::get("fields/{id}", [FieldAPIController::class, 'show']);
Route::get("levels/{id}", [LevelAPIController::class, 'show']);
Route::get("questions/{id}", [QuestionAPIController::class, 'show']);
Route::get("quizzes/{id}", [QuizAPIController::class, 'show']);
Route::get("skills/{id}", [SkillAPIController::class, 'show']);
Route::get("users/{id}", [UserAPIController::class, 'show']);
Route::get("countries/{id}", [CountryAPIController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::prefix('answers')->group(function() {
        Route::post('/', [AnswerAPIController::class, 'store']);
        Route::patch('/{id}', [AnswerAPIController::class, 'update_attribute']);
        Route::put('/{id}', [AnswerAPIController::class, 'update_all']);
        Route::delete('/{id}', [AnswerAPIController::class, 'delete']);
    });

    Route::prefix('fields')->group(function() {
        Route::post('/', [FieldAPIController::class, 'store']);
        Route::patch('/{id}', [FieldAPIController::class, 'update_attribute']);
        Route::put('/{id}', [FieldAPIController::class, 'update_all']);
        Route::delete('/{id}', [FieldAPIController::class, 'delete']);
    });

    Route::prefix('questions')->group(function() {
        Route::post('/', [QuestionAPIController::class, 'store']);
        Route::patch('/{id}', [QuestionAPIController::class, 'update_attribute']);
        Route::put('/{id}', [QuestionAPIController::class, 'update_all']);
        Route::delete('/{id}', [QuestionAPIController::class, 'delete']);
    });

    Route::prefix('quizzes')->group(function() {
        Route::post('/', [QuizAPIController::class, 'store']);
        Route::patch('/{id}', [QuizAPIController::class, 'update_attribute']);
        Route::put('/{id}', [QuizAPIController::class, 'update_all']);
        Route::delete('/{id}', [QuizAPIController::class, 'delete']);
    });

    Route::prefix('skills')->group(function() {
        Route::post('/', [SkillAPIController::class, 'store']);
        Route::patch('/{id}', [SkillAPIController:: class, 'update_attribute']);
        Route::put('/{id}', [SkillAPIController::class, 'update_all']);
        Route::delete('/{id}', [SkillAPIController::class, 'delete']);
    });

    Route::prefix('users')->group(function() {
        Route::patch('/{id}', [UserAPIController::class, 'update_attribute']);
        Route::put('/{id}', [UserAPIController::class, 'update_all']);
    });

    /* Logout an authorized user */
    Route::post('logout', [AuthAPIController::class, 'logout']);
});

/**
 * Using Spatie's Health package
 */
Route::get('health', HealthCheckJsonResultsController::class);

Route::fallback([APIFallbackController::class, 'error']);
