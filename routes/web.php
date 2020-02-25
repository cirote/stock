<?php

Route::get('/home', 'StockController@index');

Route::get('/', 'StockController@index');

Route::get('/activos', 'StockController@index')->name('activo.index');
Route::get('/activos/anteriores', 'StockController@anteriores')->name('activo.anteriores');
Route::get('/activos/{activo}/mayor', 'StockController@mayor')->name('activo.mayor');

Route::get('/ccl/{activo}', 'StockController@ccl');
Route::get('/sma/{activo}', 'StockController@sma');

Route::get('/broker', 'BrokerController@index')->name('broker.index');
Route::get('/broker/{broker}/aportes', 'BrokerController@aportes')->name('broker.aportes');
