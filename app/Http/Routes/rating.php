<?php

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix' => 'rating'], function () {
		Route::get('/{id}/{type?}', [
			'uses' 		 => 'Front\RatingController@index',
			'as'   		 => 'rating.list'
		]);

		Route::get('/{id}/{contractId}/rate', [
			'uses' 		 => 'Front\RatingController@show',
			'as'   		 => 'rating.show',
			'middleware' => 'rating'
		]);

		Route::post('/postRating', [
			'uses'	=> 'Front\RatingController@postRating',
			'as'	=> 'rating.post'
		]);
	});
});