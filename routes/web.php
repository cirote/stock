<?php

Route::get('/', 'BrokerController@index');
Route::get('/home', 'BrokerController@index');

Route::get('/acciones', 'AccionesController@index')->name('acciones.index');

Route::get('/bonos', 'BonosController@index')->name('bonos.index');

Route::get('/opciones', 'OpcionesController@index')->name('opciones.index');
Route::get('/opciones/{activo}', 'OpcionesController@activo')->name('opciones.activo');

Route::get('/activos', 'StockController@index')->name('activo.index');
Route::get('/activos/{broker}', 'StockController@broker')->name('activo.broker.index');
Route::get('/activos/anteriores', 'StockController@anteriores')->name('activo.anteriores');
Route::get('/activos/{activo}/mayor', 'StockController@mayor')->name('activo.mayor');

Route::get('/broker', 'BrokerController@index')->name('broker.index');
Route::get('/broker/{broker}/aportes', 'BrokerController@aportes')->name('broker.aportes');

Route::get('/ccl/{activo}', 'StockController@ccl');
Route::get('/sma/{activo}', 'StockController@sma');

Route::get('/datos/dolar', 'DatosController@store_dolar');
Route::get('/datos/acciones', 'DatosController@store_acciones');
Route::get('/datos/bonos', 'DatosController@store_bonos');
Route::get('/datos/opciones', 'DatosController@store_opciones');
