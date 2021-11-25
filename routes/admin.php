<?php 

Route::prefix('/admin')->group(function(){
	Route::get('/', 'Admin\DashboardController@getDashboard');
	Route::get('/users', 'Admin\UserController@getUsers');


	//modulo de producto

	Route::get('/products', 'Admin\ProductController@getHome');
	Route::get('/products/add', 'Admin\ProductController@getProductAdd');
	Route::get('/product/{id}/edit', 'Admin\ProductController@getProductEdit');
	Route::post('/products/add', 'Admin\ProductController@postProductAdd');
	Route::post('/product/{id}/edit', 'Admin\ProductController@postProductEdit');
	Route::get('/product/{id}/delete', 'Admin\ProductController@getProductDelete');

	//Categorias
	Route::get('/categories/{module}', 'Admin\CategoriesController@getHome');
	Route::post('/category/add', 'Admin\CategoriesController@postCategoryAdd');

});

