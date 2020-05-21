<?php

Route::middleware(['web'])->namespace('Cirote\Opciones\Controllers')
	->prefix('inexistentes')
	->name('inexistentes.')
	->group(function() 
	{
		Route::get('/', 'InexistentesController@index')->name('index');
		Route::get('/{activo}/mostrar', 'InexistentesController@mostrar')->name('mostrar');
		Route::get('/{activo}/agregar', 'InexistentesController@agregar')->name('agregar');
		Route::get('/{activo}/borrar', 'InexistentesController@borrar')->name('borrar');
	});

Route::middleware(['web'])->namespace('Cirote\Opciones\Controllers')
	->prefix('datos')
	->name('datos.')
	->group(function() 
	{
		Route::get('/opciones', 'DatosController@store_opciones')->name('opciones');
	});

Route::middleware(['web'])->namespace('Cirote\Opciones\Controllers')
	->prefix('opciones')
	->name('opciones.')
	->group(function() 
	{
		Route::get('/', 'OpcionesController@index')->name('index');
		Route::get('/{activo}', 'OpcionesController@activo')->name('activo');
	});
