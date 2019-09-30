<?php

Route::get('/home', 'StockController@index');

Route::get('/', 'StockController@index');

Route::get('/activo/{activo}/mayor', 'StockController@mayor')->name('activo.mayor');
Route::get('/ccl/{activo}', 'StockController@ccl');
Route::get('/sma/{activo}', 'StockController@sma');
