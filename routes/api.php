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
    Route::put('{freelancer}/profile', 'ProfileController@update');
    Route::resource('{freelancer}/profile', 'ProfileController');
    Route::post('{freelancer}/profile/review', 'ProfileController@addReview');
    Route::post('profile/addexp','ProfileController@addExp');
    Route::post('profile/delexp','ProfileController@delExp');
    Route::post('profile/editexp','ProfileController@editExp');
    Route::post('profile/addcert','ProfileController@addCert');
    Route::post('profile/delcert','ProfileController@delCert');
    Route::post('profile/editcert','ProfileController@editCert');
});

Route::apiResource('freelancer','FreelancerController');
Route::post('freelancer/filter','FreelancerController@filter' );
Route::get('myprojects','FreelancerController@getProjects');

Route::apiResource('client','ClientController');

Route::get('/settings/projects','ClientController@getProjects');

Route::apiResource('project','ProjectController');
Route::post('project/filter','ProjectController@getFilteredProjects');
Route::post('project/{project}/bid', 'ProjectController@createBid');
Route::post('project/{project}/settimer', 'ProjectController@setTimer');
Route::post('project/{project}/task', 'ProjectController@setTask');
Route::delete('project/{project}/task', 'ProjectController@deleteTask');
Route::get('project/{project}/task', 'ProjectController@getTasks');
Route::get('project/{project}/gettimer', 'ProjectController@getTimer');
Route::post('project/{project}/{freelancer}/accept', 'ProjectController@hireFreelancer');
Route::post('project/{project}/{freelancer}/deny', 'ProjectController@denyFreelancer');
Route::get('project/{project}/{freelancer}/contract', 'ProjectController@getContract');

Route::get('categories','ProjectController@getCategories');
Route::post('categories','ProjectController@setCategory');
Route::put('categories/{id}','ProjectController@editCategory');
Route::delete('categories/{id}','ProjectController@deleteCategory');


Route::get('/contacts','ContactsController@get');
Route::get('/conversation/{id}','ContactsController@getMessagesFor');
Route::post('/conversation/send','ContactsController@send');
Route::post('/conversation/sendAttachment','ContactsController@sendAttachment');

Route::get('/dashboard/freelancers','adminDashboardController@getFreelancers');
Route::put('/dashboard/freelancers/{freelancer}','adminDashboardController@editFreelancers');
Route::delete('/dashboard/freelancers/{freelancer}','adminDashboardController@deleteFreelancers');
Route::get('/dashboard/clients','adminDashboardController@getClients');
Route::put('/dashboard/clients/{client}','adminDashboardController@editClients');


Route::get('skills','SkillController@index');
Route::post('skills','SkillController@store');
Route::put('skills/{skill}','SkillController@edit');
Route::delete('skills/{skill}','SkillController@destroy');


