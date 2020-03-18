<?php

Route::get('/', 'BrokerController@index');
Route::get('/home', 'BrokerController@index');

Route::get('/activos', 'StockController@index')->name('activo.index');
Route::get('/activos/{broker}', 'StockController@broker')->name('activo.broker.index');
Route::get('/activos/anteriores', 'StockController@anteriores')->name('activo.anteriores');
Route::get('/activos/{activo}/mayor', 'StockController@mayor')->name('activo.mayor');

Route::get('/broker', 'BrokerController@index')->name('broker.index');
Route::get('/broker/{broker}/aportes', 'BrokerController@aportes')->name('broker.aportes');

Route::get('/ccl/{activo}', 'StockController@ccl');
Route::get('/sma/{activo}', 'StockController@sma');

Route::get('/datos', 'DatosController@store');
