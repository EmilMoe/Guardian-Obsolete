<?php

Route::resource('permissions', 'PermissionsController', ['only' => ['store', 'index', 'update', 'destroy', 'show']]);
Route::resource('roles',       'RolesController',       ['only' => ['store', 'index', 'update', 'destroy', 'show']]);

Route::group([
    'prefix'    => 'roles/{roles}/permissions',
    'namespace' => 'Roles',
    'as'        => str_replace('/', '.', config('guardian.api.url')) .'.roles.permissions.'
], function() {
    Route::patch('add/{permissions}',    ['as' => 'add',    'uses' => 'PermissionsController@add']);
    Route::patch('remove/{permissions}', ['as' => 'remove', 'uses' => 'PermissionsController@remove']);
});

Route::group([
    'prefix'    => 'roles/{roles}/users',
    'namespace' => 'Roles',
    'as'        => str_replace('/', '.', config('guardian.api.url')) .'.roles.users.'
], function() {
    Route::patch('add/{users}',    ['as' => 'add',    'uses' => 'UsersController@add']);
    Route::patch('remove/{users}', ['as' => 'remove', 'uses' => 'UsersController@remove']);
});