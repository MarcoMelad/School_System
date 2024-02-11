<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    public function index()
    {
        $ids = DB::table('teacher_section')->where('teacher_id',auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id',$ids)->get();

        return view('pages.Teachers.dashboard.students.index',compact('students'));
    }


}