<?php

Route::get('/', array('uses' => 'HomeController@index'));
Route::post('/', array('uses' => 'PetController@getNearby'));

Route::get('/pet/{pet_id}', array('uses' => 'PetController@showNearby'));

Route::get('/pet/get/{zipcode}/{animal}/{offset}', array('uses' => 'PetController@getNearbyJSON'));

Route::get('/vote/{pet_id}/{rating_slug}', array('uses' => 'VoteController@cast'));

Route::get('top/{rating_slug}', array('uses' => 'PetController@getTop'));
Route::get('top/{rating_slug}/offset/{offset}', array('uses' => 'PetController@getTopJSON'));
Route::get('top/{rating_slug}/{pet_id}', array('uses' => 'PetController@showTop'));

Route::get('pet/getStatus/{pet_id}', array('uses' => 'PetController@getStatus'));