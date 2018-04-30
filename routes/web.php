<?php

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

// Authorization
Route::get('/login', 'Auth\SessionController@getLogin')->name('auth.login.form');
Route::post('/login', 'Auth\SessionController@postLogin')->name('auth.login.attempt');
Route::get('/logout', 'Auth\SessionController@getLogout')->name('auth.logout');

// Registration
Route::get('register', 'Auth\RegistrationController@getRegister')->name('auth.register.form');
Route::post('register', 'Auth\RegistrationController@postRegister')->name('auth.register.attempt');

// Activation
Route::get('activate/{code}', 'Auth\RegistrationController@getActivate')->name('auth.activation.attempt');
Route::get('resend', 'Auth\RegistrationController@getResend')->name('auth.activation.request');
Route::post('resend', 'Auth\RegistrationController@postResend')->name('auth.activation.resend');

// Password Reset
Route::get('password/reset/{code}', 'Auth\PasswordController@getReset')->name('auth.password.reset.form');
Route::post('password/reset/{code}', 'Auth\PasswordController@postReset')->name('auth.password.reset.attempt');
Route::get('password/reset', 'Auth\PasswordController@getRequest')->name('auth.password.request.form');
Route::post('password/reset', 'Auth\PasswordController@postRequest')->name('auth.password.request.attempt');

// Users
Route::resource('users', 'UserController');

// Navbar
Route::get('view', ['as' => 'view', 'uses' => 'SelectController@select']);
Route::post('view', ['as' => 'view_form', 'uses' => 'SelectController@get_parking']);

Route::get('view/{slug}', ['as' => 'parking_view', 'uses' => 'SelectController@view_parking']);

Route::get('create', 'ParkingsController@create_form');
Route::post('create', ['as' => 'create', 'uses' => 'ParkingsController@create']);

// Roles
Route::resource('roles', 'RoleController');

// Dashboard
Route::get('dashboard', ['as' => 'dashboard', 'uses' => function() {
    return view('centaur.dashboard');
}]);

// Home
Route::get('/', ['as' => 'index', 'uses' => 'SelectController@index']);

// Simulator
Route::get('simulator', ['as' => 'simulator', 'uses' => 'SelectController@select']);
Route::post('simulator', ['as' => 'post_simulator', 'uses' => 'SelectController@get_parking']);

Route::get('simulator/{slug}', ['as' => 'parking_select', 'uses' => 'SelectController@view_parking']);
Route::post('simulator/{slug}', ['as' => 'simulator_forms', 'uses' => 'SimulatorController@parking_form']);
