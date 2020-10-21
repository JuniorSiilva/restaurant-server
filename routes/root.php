<?php

Route::post('customers', ['as' => 'customers.create', 'uses' => 'CustomerController@create']);

Route::get('users/{email}/tenanties', ['as' => 'users.tenanties', 'uses' => 'UserController@tenanties', 'middleware' => 'guest:api']);
