<?php

use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\SkillController;

Route::group(['prefix'=>'auth','namespace'=>'Auth'],function(){
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::post('signup', 'signUpController');
    Route::get('me', 'MeController');
});

Route::group(['prefix'=>'freelancer', 'namespace'=>'freelancer'],function(){
    Route::resource('{freelancer}/profile', 'ProfileController');
});

Route::apiResource('freelancer','FreelancerController');

Route::apiResource('client','ClientController');

Route::apiResource('project','ProjectController');

Route::get('skills','SkillController@index');
