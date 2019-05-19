<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('/login');
});


//Route::get('/register', 'Auth\RegisterController@index');

Auth::routes();


Route::group(['middleware' => ['auth']], function() {

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/students', 'StudentController@index');
	Route::post('/addStudent', 'StudentController@addStudent');
	Route::post('/editStudent', 'StudentController@editStudent');
	Route::post('/deleteStudent', 'StudentController@deleteStudent');

	Route::get('/subjects', 'SubjectController@index');
	Route::post('/addSubject', 'SubjectController@addSubject');
	Route::post('/editSubject', 'SubjectController@editSubject');
	Route::post('/deleteSubject', 'SubjectController@deleteSubject');

	Route::get('/sections', 'SectionController@index');
	Route::post('/addSection', 'SectionController@addSection');
	Route::post('/editSection', 'SectionController@editSection');
	Route::post('/deleteSection', 'SectionController@deleteSection');

	Route::get('/settings', 'TeacherController@index');
	Route::post('/editTeacher', 'TeacherController@editTeacher');
	Route::post('/editPassword', 'TeacherController@editPassword');


	Route::get('/datatableStudent', 'DatatablesController@getStudents');
	Route::get('/datatableSection', 'DatatablesController@getSections');
	Route::get('/datatableSubject', 'DatatablesController@getSubjects');

});
