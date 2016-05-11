<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Table Structure
    |--------------------------------------------------------------------------
    |
    | This setting should be set before you migrate and not changed after.
    |
    | This option controls which tables in your database will be used to
    | store the different roles and their permissions. It is used for
    | the overall regulations.
    |
    */

    'table' => [
        'role'          => 'roles',
        'permission'    => 'permissions'
    ],

    /*
    |--------------------------------------------------------------------------
    | User Data
    |--------------------------------------------------------------------------
    |
    | This setting should be set before you migrate and not changed after.
    | Also be careful to change your architecture related to your user
    | specific logic.
    |
    | The user option allows Guardian to detect your users table and id.
    |
    */

    'user'  => [
        'model' => App\User::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Denied
    |--------------------------------------------------------------------------
    |
    | Whenever a user reaches a point with no permission, you can redirect them
    | to a URL given here. Default value is null, which will return an
    | abort(403);
    |
    */

    'redirect' => null,

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    |
    | The API gives you some basic URIs to access to perform common operations.
    |
    | The URL is a prefix for all API calls. php artisan route:list will
    | describe more in detail what the URIs are.
    | Also the endpoint naming is affected by the url option.
    |
    */

    'api' => [
        'enabled' => true,
        'url'     => 'api/guardian',
    ],

    /*
    |--------------------------------------------------------------------------
    | Multi Client Installation
    |--------------------------------------------------------------------------
    |
    | This setting should be set before you migrate and not changed after.
    | Also be careful to change your architecture related to your user
    | and client specific logic.
    |
    | If your application serves several clients within the same application
    | this is where you want to assign which model that serves your clients.
    | Are upi hosting a Software as a Service (SaaS) solution, this is where
    | you want to reference, how your clients are identified.
    |
    | The model is where you define the model class for you client base.
    | Relation is the method called on Auth::user() in order to find current
    | client id.
    |
    */

    'client' => [
        'model'    => App\Clients::class,
        'relation' => 'client',
    ],
];