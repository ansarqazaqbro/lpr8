<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — ЛПР №8 & ЛПР №9 (Вариант 9 — Ресторан)
| Студент: Каиргельдинов Ансар, ИС24-23б, N=9
|--------------------------------------------------------------------------
*/

// Редирект с главной на каталог
Route::redirect('/', '/catalog')->name('home');

// ----- Каталог (ЛПР №8) -----
Route::prefix('catalog')->name('catalog.')->group(function () {

    // Список с поиском и сортировкой
    Route::get('/', [CatalogController::class, 'index'])->name('index');

    // Фильтр по разделу меню (необязательный параметр)
    Route::get('/section/{section?}', [CatalogController::class, 'bySection'])->name('section');

    // Карточка по коду (ABC-123)
    Route::get('/code/{code}', [CatalogController::class, 'byCode'])
        ->name('code')
        ->where('code', '[A-Z]{3}-[0-9]{3}');

    // Карточка по id (только цифры)
    Route::get('/{id}', [CatalogController::class, 'show'])
        ->name('show')
        ->whereNumber('id');
});

// ----- CRUD Управление блюдами (ЛПР №9) -----
Route::resource('dishes', DishController::class)->except(['show']);

// ----- Обратная связь -----
Route::get('/feedback', [PageController::class, 'feedbackForm'])->name('feedback.form');
Route::post('/feedback', [PageController::class, 'feedbackSend'])->name('feedback.send');

// ----- Тестовый маршрут (поддержка кириллицы) -----
Route::get('/hello/{name?}', function (?string $name = null) {
    $greeting = $name ? 'Привет, '.$name.'!' : 'Привет, мир!';

    return view('hello', compact('greeting'));
})->where('name', '[\p{L}]+')->name('hello');
