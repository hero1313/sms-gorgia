<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SmsController;


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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {


    //employee
    Route::get('/dashboard',[EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/',[EmployeeController::class, 'index'])->name('employee.index');
    Route::get('employee',[EmployeeController::class, 'index'])->name('employee.index');
    Route::post('add-employee',[EmployeeController::class, 'store'])->name('employee.store');
    Route::put('update-employee/{id}',[EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('delete-employee/{id}',[EmployeeController::class, 'delete'])->name('employee.delete');
    Route::get('/excel-export',[EmployeeController::class, 'excelExport']);
    Route::post('/excel-import',[EmployeeController::class, 'excelImport']);


    //sms
    Route::get('sms',[SmsController::class, 'index'])->name('sms.index');
    Route::post('add-sms',[SmsController::class, 'store'])->name('sms.store');
    Route::put('update-sms/{id}',[SmsController::class, 'update'])->name('sms.update');
    Route::delete('delete-sms/{id}',[SmsController::class, 'delete'])->name('sms.delete');

    // branch
    Route::get('branch',[BranchController::class, 'index'])->name('branch.index');
    Route::post('add-branch',[BranchController::class, 'store'])->name('branch.store');
    Route::delete('delete-branch/{id}',[BranchController::class, 'delete'])->name('branch.delete');

    // department
    Route::get('department',[DepartmentController::class, 'index'])->name('department.index');
    Route::post('add-department',[DepartmentController::class, 'store'])->name('department.store');
    Route::delete('delete-department/{id}',[DepartmentController::class, 'delete'])->name('department.delete');

    // send sms
    Route::get('/get-sms-ajax',[SmsController::class, 'getSms']);
    Route::get('/get-department-ajax',[SmsController::class, 'getDepartment']);
    Route::get('/get-employee-ajax',[SmsController::class, 'getEmployee']);
    Route::get('/get-branch-ajax',[SmsController::class, 'getBranch']);
    Route::get('/get-filter-users-ajax',[SmsController::class, 'getFilterUsers']);
    Route::post('/sms-birthday',[SmsController::class, 'smsBirthday'])->name('sms.birthday');
    Route::post('sms-users/{id}',[SmsController::class, 'smsUser'])->name('sms.user');
    Route::post('/sms-group',[SmsController::class, 'smsGroup'])->name('sms.group');
});
