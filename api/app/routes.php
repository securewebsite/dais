<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
|
|--------------------------------------------------------------------------
| 	Application Routes
|--------------------------------------------------------------------------
|
| 	Here is where you can register all of the routes for an application.
| 	It's a breeze. Simply tell Laravel the URIs it should respond to
| 	and give it the controller to call when that URI is requested.
|
*/

$app->get('/api', 'App\Controllers\DefaultController@index');
$app->get('/api/v1', 'App\Controllers\DefaultController@index');

$app->group(['prefix' => 'api/v1','namespace' => 'App\Controllers'], function($app) {
    // address
    $app->get('address','Front\Account\AddressController@index');

    // products
    $app->get('product','Front\Catalog\ProductController@index');
	$app->get('product/{id}','Front\Catalog\ProductController@getProduct');
	$app->post('product','Front\Catalog\ProductController@createProduct');
	$app->put('product/{id}','Front\Catalog\ProductController@updateProduct');
	$app->delete('product/{id}','Front\Catalog\ProductController@deleteProduct');
});
