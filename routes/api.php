<?php

Route::group(['prefix'=>'auth','namespace'=>'Auth'],function(){
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::post('signup', 'signUpController');
    Route::get('me', 'MeController');
});
