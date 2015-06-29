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

Route::post('pull_update', function(){

    $secret = env('GITHUB_PULL_SECRET');

    $headers = getallheaders();
    $hubSignature = $headers['X-Hub-Signature'];

    // Split signature into algorithm and hash
    list($algo, $hash) = explode('=', $hubSignature, 2);

    // Get payload
    $payload = file_get_contents('php://input');
    $payload = json_decode($payload);
    $payload = json_encode($payload);
    $payload = str_replace('\/', '/', $payload);


    // Calculate hash based on payload and the secret
    $payloadHash = hash_hmac($algo, $payload, $secret);

    if($hash === $payloadHash){
        // execute git pull
        return shell_exec("git pull");
    }
    return 'Wrong Hash';
});
