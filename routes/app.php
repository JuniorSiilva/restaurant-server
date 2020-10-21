<?php

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('tokens', ['as' => 'tokens', 'uses' => 'AuthController@tokens', 'middleware' => 'auth:sanctum']);
    Route::post('login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'AuthController@logout', 'middleware' => 'auth:sanctum']);
    Route::post('revoke/{id}', ['as' => 'revoke', 'uses' => 'AuthController@revoke', 'middleware' => ['auth:sanctum', 'exists:personal_access_tokens|id|id']]);
});

Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
    Route::post('lost', ['as' => 'lost', 'uses' => 'ForgotPasswordController@lost']);
    Route::post('reset/{token}', ['as' => 'reset', 'uses' => 'ForgotPasswordController@reset']);
});

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::post('', ['as' => 'create', 'uses' => 'UserController@create']);
    Route::put('users/profile', ['uses' => 'UserController@profileUpdate', 'as' => 'users.profile.update', 'middleware' => 'auth:sanctum']);
    Route::get('verify/{id}', ['as' => 'verify', 'uses' => 'UserController@verify', 'middleware' => ['signed', 'exists:users|id|id|deleted_at']]);
    Route::get('profile', ['as' => 'profile', 'uses' => 'UserController@profile', 'middleware' => 'auth:sanctum']);
});

Route::group(['prefix' => 'attachments', 'as' => 'attachments.', 'middleware' => 'auth:sanctum'], function () {
    Route::delete('/{id}', ['as' => 'remove', 'uses' => 'AttachmentController@remove', 'middleware' => 'exists:attachments|id|id|deleted_at']);
});

Route::group(['prefix' => 'dishes', 'as' => 'dishes.'], function () {
    Route::get('menu', ['as' => 'menu', 'uses' => 'DishController@menu']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('', ['as' => 'get', 'uses' => 'DishController@get']);
        Route::post('', ['as' => 'create', 'uses' => 'DishController@create']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'DishController@update', 'middleware' => 'exists:dishes|id|id|deleted_at']);
        Route::get('/{id}', ['as' => 'find', 'uses' => 'DishController@find', 'middleware' => 'exists:dishes|id|id|deleted_at']);
        Route::post('/{id}/attachments', ['as' => 'attachments', 'uses' => 'DishController@newAttachments', 'middleware' => 'exists:dishes|id|id|deleted_at']);

        Route::post('/{id}/optionals', ['as' => 'optionals.create', 'uses' => 'DishController@createOptional', 'middleware' => 'exists:dishes|id|id|deleted_at']);
        Route::put('/{id}/optionals/{optionalId}', ['as' => 'optionals.update', 'uses' => 'DishController@updateOptional', 'middleware' => ['exists:dishes|id|id|deleted_at', 'exists:dish_optionals|optionalId|id|deleted_at']]);
        Route::delete('/{id}/optionals/{optionalId}', ['as' => 'optionals.remove', 'uses' => 'DishController@removeOptional', 'middleware' => ['exists:dishes|id|id|deleted_at', 'exists:dish_optionals|optionalId|id|deleted_at']]);
    });
});

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    Route::get('rank', ['as' => 'rank', 'uses' => 'CategoryController@getRankCategories']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('', ['as' => 'get', 'uses' => 'CategoryController@get']);
        Route::post('', ['as' => 'create', 'uses' => 'CategoryController@create']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'CategoryController@update', 'middleware' => 'exists:categories|id|id|deleted_at']);
        Route::get('/{id}', ['as' => 'find', 'uses' => 'CategoryController@find', 'middleware' => 'exists:categories|id|id|deleted_at']);
    });
});

Route::group(['prefix' => 'tables', 'as' => 'tables.', 'middleware' => 'auth:sanctum'], function () {
    Route::get('', ['as' => 'get', 'uses' => 'TableController@get']);
    Route::post('', ['as' => 'create', 'uses' => 'TableController@create']);
    Route::put('/{id}', ['as' => 'update', 'uses' => 'TableController@update', 'middleware' => 'exists:tables|id|id|deleted_at']);
    Route::get('/{id}', ['as' => 'find', 'uses' => 'TableController@find', 'middleware' => 'exists:tables|id|id|deleted_at']);
});

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::post('', ['as' => 'create', 'uses' => 'OrderController@create', 'middleware' => 'auth:sanctum']);

    Route::middleware(['exists:orders|id|id|deleted_at', 'order'])->group(function () {
        Route::post('/{id}/close', ['as' => 'close', 'uses' => 'OrderController@close']);
        Route::post('/{id}/request', ['as' => 'request', 'uses' => 'OrderController@request']);
    });
});
