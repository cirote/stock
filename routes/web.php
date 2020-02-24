<?php

Route::get('/home', 'StockController@index');

Route::get('/', 'StockController@index');

Route::get('/activos', 'StockController@index')->name('activo.index');
Route::get('/anteriores', 'StockController@anteriores')->name('activo.anteriores');
Route::get('/activo/{activo}/mayor', 'StockController@mayor')->name('activo.mayor');

Route::get('/ccl/{activo}', 'StockController@ccl');
Route::get('/sma/{activo}', 'StockController@sma');

Route::get('/aportes/{broker}', 'BrokerController@aportes')->name('broker.aportes');
