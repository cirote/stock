<?php

Route::get('/', 'StockController@index');

Route::get('/ccl/{activo}', 'StockController@ccl');
Route::get('/sma/{activo}', 'StockController@sma');
