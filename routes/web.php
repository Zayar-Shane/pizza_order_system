<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// for pizza order System

//login && register
Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage', 301);
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['admin_auth'])->group(function () {
        // Category
        Route::prefix('category')->group(function () {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });

        // admin account
        Route::prefix('admin')->group(function () {
            //password
            Route::get('password/changePage', [AdminController::class, 'changePasswordPage'])->name('admin#passwordChangePage');
            Route::post('change/password', [AdminController::class, 'changePassword'])->name('admin#changePassword');

            // Profile
            Route::get('details', [AdminController::class, 'details'])->name('admin#details');
            Route::get('edit', [AdminController::class, 'edit'])->name('admin#edit');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('admin#update');

            // Account list
            Route::get('list', [AdminController::class, 'list'])->name('admin#list');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin#delete');
            Route::get('ajax/role/change', [AdminController::class, 'roleChange'])->name('admin#roleChange');
        });

        // Products
        Route::prefix('products')->group(function () {
            Route::get('list', [ProductController::class, 'listPage'])->name('product#listPage');
            Route::get('create', [ProductController::class, 'createPage'])->name('product#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('product#create');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');
            Route::get('detail/{id}', [ProductController::class, 'detail'])->name('product#detail');
            Route::get('update/{id}', [ProductController::class, 'updatePage'])->name('product#updatePage');
            Route::post('update', [ProductController::class, 'update'])->name('product#update');
        });

        // order list
        Route::prefix('order')->group(function () {
            Route::get('list', [OrderController::class, 'orderList'])->name('order#list');
            Route::get('order/status', [OrderController::class, 'orderStatus'])->name('admin#orderStatus');
            Route::get('ajax/change/status', [OrderController::class, 'ajaxChangeStatus'])->name('admin#ajaxChangeStatus');
            Route::get('listInfo/{orderCode}', [OrderController::class, 'listInfo'])->name('order#listInfo');
        });

        // user list in admin dashboard
        Route::prefix('user')->group(function () {
            Route::get('list', [UserController::class, 'userList'])->name('admin#userList');
            Route::get('ajax/change/userRole', [UserController::class, 'userChangeRole'])->name('admin#userChangeRole');
        });

        // user message for admin
        Route::prefix('contact')->group(function () {
            Route::get('message', [ContactController::class, 'message'])->name('contact#message');
            Route::get('delete/message/{id}', [ContactController::class, 'deleteMessage'])->name('contact#deleteMessage');
            Route::get('view/message/{id}', [ContactController::class, 'viewMessage'])->name('contact#viewMessage');
        });

    });

    // user
    //home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        Route::get('/homePage', [UserController::class, 'home'])->name('user#home');
        Route::get('filter/{id}', [UserController::class, 'filter'])->name('user#filter');

        Route::prefix('pizza')->group(function () {
            Route::get('details/{id}', [UserController::class, 'pizzaDetails'])->name('pizza#details');
        });

        Route::prefix('cart')->group(function () {
            Route::get('list', [CartController::class, 'list'])->name('cart#list');
            Route::get('history', [CartController::class, 'history'])->name('cart#histroy');
        });

        Route::prefix('password')->group(function () {
            Route::get('change', [UserController::class, 'changePage'])->name('password#changePage');
            Route::post('change', [UserController::class, 'change'])->name('password#change');
        });

        Route::prefix('profile')->group(function () {
            Route::get('update', [UserController::class, 'updateProfile'])->name('profile#updateProfile');
            Route::post('update/{id}', [UserController::class, 'update'])->name('profile#update');
        });

        Route::prefix('contact')->group(function () {
            Route::get('contactPage', [ContactController::class, 'contactPage'])->name('contact#contactPage');
            Route::post('contactToAdmin', [ContactController::class, 'contactToAdmin'])->name('contact#contactToAdmin');
        });

        Route::prefix('ajax')->group(function () {
            Route::get('pizza/list', [AjaxController::class, 'pizzaList'])->name('ajax#pizzaList');
            Route::get('addToCart', [AjaxController::class, 'addToCart'])->name('ajax#addTocart');
            Route::get('order', [AjaxController::class, 'order'])->name('ajax#order');
            Route::get('clear/cart', [AjaxController::class, 'clearCart'])->name('ajax#clearCart');
            Route::get('clear/currentItem', [AjaxController::class, 'clearCurrentItem'])->name('ajax#clearCurrentItem');
            Route::get('incease/viewCount', [AjaxController::class, 'increaseViewCount'])->name('ajax#increaseViewCount');
        });

    });

});
