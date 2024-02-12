<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteService Provider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index')->name('selection');


Route::group(['namespace' => 'Auth'], function () {

    Route::get('/login/{type}', 'LoginController@loginForm')->middleware('guest')->name('login.show');

    Route::post('/login', 'LoginController@login')->name('login');

    Route::get('/logout/{type}', 'LoginController@logout')->name('logout');
});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () {

    /*        Route::get('/', function()
            {
                return View::make('dashboard');
            });*/

    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::group(['namespace' => 'Grades'], function () {
        Route::resource('Grades', 'GradeController');
    });

    Route::group(['namespace' => 'Classrooms'], function () {
        Route::resource('Classrooms', 'ClassroomController');
        Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');

        Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');
    });
    Route::group(['namespace' => 'Sections'], function () {
        Route::resource('Sections', 'SectionController');
        Route::get('/classes/{id}', 'SectionController@getclasses');
    });

    Route::view('add_parent', 'livewire.show_Form')->name('add_parent');


    Route::group(['namespace' => 'Teachers'], function () {
        Route::resource('Teachers', 'TeacherController');
    });

    Route::group(['namespace' => 'Students'], function () {
        Route::resource('Students', 'StudentController');
        Route::resource('Graduated', 'GraduatedController');
        Route::resource('Promotion', 'PromotionController');
        Route::resource('Fees', 'FeesController');
        Route::resource('Fees_Invoices', 'FeesInvoicesController');
        Route::resource('receipt_students', 'ReceiptStudentsController');
        Route::resource('ProcessingFee', 'ProcessingFeeController');
        Route::resource('Payment_students', 'PaymentController');
        Route::resource('Attendance', 'AttendanceController');
        Route::resource('online_classes', 'OnlineClasseController');
        Route::get('/indirect_admin', 'OnlineClasseController@indirectCreate')->name('indirect.create');
        Route::post('/indirect_admin', 'OnlineClasseController@storeIndirect')->name('indirect.store');
        Route::resource('library', 'LibraryController');
        Route::get('download_file/{filename}', 'LibraryController@downloadAttachment')->name('downloadAttachment');
        Route::post('Upload_attachment', 'StudentController@Upload_attachment')->name('Upload_attachment');
        Route::get('Download_attachment/{studentsname}/{filename}', 'StudentController@Download_attachment')->name('Download_attachment');
        Route::post('Delete_attachment', 'StudentController@Delete_attachment')->name('Delete_attachment');
    });

    Route::group(['namespace' => 'Subjects'], function () {
        Route::resource('subjects', 'SubjectController');
    });

    Route::group(['namespace' => 'Quizzes'], function () {
        Route::resource('Quizzes', 'QuizzController');
    });

    Route::group(['namespace' => 'questions'], function () {
        Route::resource('questions', 'QuestionController');
    });

    Route::group(['namespace' => 'settings'], function () {
        Route::resource('settings', 'SettingController');
    });

});



