<?php

Route::middleware(['web'])->namespace('Cirote\Estrategias\Controllers')
	->prefix('estrategias')
	->name('estrategias.')
	->group(function() 
	{
		Route::get('/lanzamiento', 'EstrategiasController@lanzamiento_cubierto')->name('lanzamiento_cubierto');
	});
