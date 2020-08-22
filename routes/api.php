<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// ROOT ROUTES
Route::post('/country/store','RootController@createCountry');
Route::get('/country','RootController@getCountries');
Route::patch('/country/update/{$id}', 'RootController@updateCountry');
Route::get('/country/find/{$id}', 'RootController@findCountry');
Route::delete('/country/delete/{$id}', 'RootController@deleteCountry');

Route::post('/city/store', 'RootController@createCity');
Route::get('city','RootController@getCities');
Route::patch('/city/update/{$id}', 'RootController@updateCity');
Route::delete('/city/delete/{$id}', 'RootController@deleteCity');

Route::post('/accountCustomer/store', 'RootController@createAccountCustomer');
Route::get('accountCustomer','RootController@getAccountCustomers');
Route::get('/accountCustomer/find/{$id}', 'RootController@getAccountCustomerById');
Route::patch('/accountCustomer/update/{$id}', 'RootController@updateAccountCustomer');
Route::delete('/accountCustomer/delete/{$id}', 'RootController@deleteAccountCustomer');

Route::post('/accountCompany/store', 'RootController@createAccountCompany');
Route::get('accountCompany','RootController@getAccountCompanies');
Route::patch('/accountCompany/update/{$id}', 'RootController@updateAccountCompany');
Route::delete('/accountCompany/delete/{$id}', 'RootController@deleteAccountCompany');

Route::post('/agency/store', 'RootController@createAgency');
Route::get('agency','RootController@getAgencies');
Route::patch('/agency/update/{$id}', 'RootController@updateAgency');
Route::delete('/agency/delete/{$id}', 'RootController@deleteAgency');

Route::post('/agencyUser/store', 'RootController@createAgencyUser');
Route::get('agencyUser','RootController@getAgencyUser');
Route::patch('/agencyUser/update/{$id}', 'RootController@updateAgencyUser');
Route::delete('/agencyUser/delete/{$id}', 'RootController@deleteAgencyUser');

Route::post('/appLog/store', 'RootController@createAppLog');
Route::get('appLog','RootController@getAppLogs');
Route::delete('/appLog/delete/{$id}', 'RootController@deleteAppLog');

Route::post('/appSetting/store', 'RootController@createAppSetting');
Route::get('appSetting','RootController@getAppSettings');
Route::patch('/appSetting/update/{$id}', 'RootController@updateAppSetting');
Route::delete('/appSetting/delete/{$id}', 'RootController@deleteAppSetting');

Route::post('/withdrawalFee/store', 'RootController@createWithdrawalFee');
Route::get('withdrawalFee','RootController@getWithdrawalFees');
Route::patch('/withdrawalFee/update/{$id}', 'RootController@updateWithdrawalFee');
Route::delete('/withdrawalFee/delete/{$id}', 'RootController@deleteWithdrawalFee');

Route::post('/role/store', 'RootController@createRole');
Route::get('role','RootController@getRoles');
Route::patch('/role/update/{$id}', 'RootController@updateRole');
Route::delete('/role/delete/{$id}', 'RootController@deleteRole');

//USERS ROUTES
Route::post('/user/store', 'UsersController@insertUser');
Route::get('user','UsersController@getUsers');
Route::patch('/user/update/{$id}', 'UsersController@updateUser');
Route::delete('/user/delete/{$id}', 'UsersController@deleteUser');

Route::post('/outerTransaction/store', 'UsersController@createOuterTransaction');
Route::get('outerTransaction','UsersController@getOuterTransactions');
Route::get('/outerTransaction/find/{$id}', 'UsersController@getOuterTransactionById');
Route::delete('/outerTransaction/delete/{$id}', 'UsersController@deleteOuterTransaction');

Route::post('/innerTransaction/store', 'UsersController@createInnerTransaction');
Route::get('innerTransaction','UsersController@getInnerTransaction');
Route::get('/innerTransaction/find/{$id}', 'UsersController@getInnerTransactionById');
Route::delete('/innerTransaction/delete/{$id}', 'UsersController@deleteInnerTransaction');

//CUSTOMERS ROUTES
Route::post('/customer/store','CustomerController@storeCustomer');
Route::get('/customer','CustomerController@getCustomers');
Route::patch('/customer/update/{$id}', 'CustomerController@updateCustomer');
Route::get('/country/find/{$id}', 'CustomerController@findCustomer');
Route::delete('/country/delete/{$id}', 'CustomerController@deleteCustomer');






