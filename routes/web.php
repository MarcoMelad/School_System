<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return View::make('auth.login');
    });
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

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

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

    Route::view('add_parent', 'livewire.show_Form');

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
        Route::resource('library', 'LibraryController');
        Route::get('download_file/{filename}', 'LibraryController@downloadAttachment')->name('downloadAttachment');
        Route::get('/Get_classrooms/{id}', 'StudentController@Get_classrooms');
        Route::get('/Get_Sections/{id}', 'StudentController@Get_Sections');
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



