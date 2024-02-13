<?php

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('/teacher/dashboard', function () {
        $ids = Teacher::findOrFail(auth()->user()->id)->Sections()->pluck('section_id');
        $date['count_sections'] = $ids->count();
        $date['count_students'] = Student::whereIn('section_id',$ids)->count();
        return view('pages.Teachers.dashboard.dashboard',$date);
    });

    Route::group(['namespace' => 'Teachers\dashboard'], function () {
        //==============================students============================
        Route::get('student','StudentController@index')->name('student.index');
        Route::get('sections','StudentController@sections')->name('sections');
        Route::post('attendance','StudentController@attendance')->name('attendance');
        Route::get('attendance_report','StudentController@attendanceReport')->name('attendance.report');
        Route::post('attendance_search','StudentController@attendanceSearch')->name('attendance.search');
        Route::resource('quizzes','QuizzController');
        Route::resource('question','QuestionController');
        Route::resource('online_zoom_classes','OnlineZoomClassesController');
        Route::get('/indirect', 'OnlineZoomClassesController@indirectCreate')->name('indirect.teacher.create');
        Route::post('/indirect', 'OnlineZoomClassesController@storeIndirect')->name('indirect.teacher.store');
        Route::get('profile', 'ProfileController@index')->name('profile.index');
        Route::post('profile/{id}', 'ProfileController@update')->name('profile.update');
        Route::get('student_quizze/{id}','QuizzController@student_quizze')->name('student.quizze');
        Route::post('repeat_quizze', 'QuizzController@repeat_quizze')->name('repeat.quizze');
    });

});
