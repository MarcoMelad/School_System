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
        Route::get('/Get_classrooms/{id}', 'QuizzController@getClassrooms');
        Route::get('/Get_Sections/{id}', 'QuizzController@Get_Sections');
        Route::resource('question','QuestionController');

    });

});
