<?php

use App\Http\Controllers\API\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// GET
Route::get('/porduct/list', [RouteController::class, 'productList']);
Route::get('/category/list', [RouteController::class, 'categoryList']);
Route::get('/orderList', [RouteController::class, 'orderList']);
Route::get('/order/list', [RouteController::class, 'order']);
Route::get('/contacts', [RouteController::class, 'contacts']);
Route::get('delete/contacts/{id}', [RouteController::class, 'deleteContact']);

// POST
Route::post('create/category', [RouteController::class, 'createCategory']); // create category
Route::post('create/contact', [RouteController::class, 'createContact']); //delete contact
Route::post('delete/category', [RouteController::class, 'deleteCategory']); //delete category

Route::get('category/details/{id}', [RouteController::class, 'categoryDetails']);
Route::post('update/category', [RouteController::class, 'updateCategory']); //update category

/***
//get all product
localhost:8000/api/porduct/list

//get all category
localhost:8000/api/category/list

//get all orderList
localhost:8000/api/orderList

//get all order
localhost:8000/api/order/list

//get all order
localhost:8000/api/contacts

delete contact by get method
localhost:8000/api/delete/contacts/{id}

//create category by post
localhost:8000/api/create/category
{'name' : ''}

//  create contact by post
localhost:8000/api/create/contact
{
'name' : ''
'email' : ''
'message': ''
}

//delete category by post
localhost:8000/api/delete/category
{ 'id': ''}

// category detail by get
localhost:8000/api/category/details/{id}

// update category by post
localhost:8000/api/update/category
{
'category_name' : '',
'category_id' : ''
}

 ***/
