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
| 	Here is where you can register all of the routes for an apilication.
| 	It's a breeze. Simply tell Laravel the URIs it should respond to
| 	and give it the controller to call when that URI is requested.
|
*/

$api->get('/api', function(){
	return view('welcome');
});

$api->get('/api/v1', function(){
	return view('welcome');
});

$api->group(['prefix' => 'api/v1','namespace' => 'Api\Controllers'], function($api) {
    // address
    $api->get('address','Front\Account\AddressController@index');

    // products
    $api->get('product','Front\Catalog\ProductController@index');
	$api->get('product/{id}','Front\Catalog\ProductController@getProduct');
	$api->post('product','Front\Catalog\ProductController@createProduct');
	$api->put('product/{id}','Front\Catalog\ProductController@updateProduct');
	$api->delete('product/{id}','Front\Catalog\ProductController@deleteProduct');
});
