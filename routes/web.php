<?php

use App\Http\Controllers\{
    CustomerController,
    DiscountController,
    DiscountReportsController,
    EmployeeReportController,
    ExcelController,
    OrderController,
    OrdersReportsController,    
    RoleController,
    UserController,
};

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

Route::middleware(['auth'])->group(function () {
 


Route::controller(DiscountController::class)->group(function(){
    Route::get('/', 'index');  
    Route::get('birthday','birthday');
    Route::post('send_birthday_sms', 'send_birthday_sms');
    Route::post('discounts/use_discount', 'use_discount');
    Route::get('waiting_list','waiting_list');
});

Route::controller(ExcelController::class)->group(function(){
    Route::get('excel/add', 'create');
    Route::post('excel/store', 'store');
});


Route::controller(OrderController::class)->group(function(){
    Route::get('orders' , 'index');
    Route::get('orders/create/{order}','create');
    Route::post('orders/store/{order}','update');
    Route::post('orders/approval/{order}','approval');
    Route::post('orders/reject/{order}', 'reject');
});


Route::controller(OrdersReportsController::class)->group(function(){
    Route::get('delivary','delivary');
    Route::get('takeaway','takeaway');
    Route::get('departments','departments');
});

Route::controller(DiscountReportsController::class)->group(function(){
    Route::get('approval_discounts','approval_discounts');
    Route::get('reject_discounts', 'reject_discounts');
    Route::get('used_discounts', 'used_discounts');
});

Route::controller(CustomerController::class)->group(function(){
    Route::get('customers','index');
    Route::get('customers/{customer}', 'show');
});

Route::controller(EmployeeReportController::class)->group(function(){
    Route::get('reports/employee', 'index');
});

Route::controller(UserController::class)->group(function(){
    Route::get('users', 'index');
    Route::get('users/create', 'create');
    Route::post('users/store', 'store');
    Route::get('users/edit/{user}', 'edit');
    Route::post('users/update/{user}', 'update');
    Route::post('users/delete/{user}', 'delete');
});


Route::controller(RoleController::class)->group(function(){
    Route::get('roles','index');
    Route::get('roles/create','create');
    Route::post('roles/store','store');
    Route::get('roles/edit/{role}','edit');
    Route::post('roles/update/{role}','update');
    Route::post('roles/delete/{role}','delete');
});
});

