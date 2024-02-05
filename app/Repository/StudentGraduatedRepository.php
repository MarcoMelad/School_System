<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\Student;
use App\Repository\StudentGraduatedRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StudentGraduatedRepository implements StudentGraduatedRepositoryInterface
{
    public function index()
    {
        $students = Student::onlyTrashed()->get();
        return view('pages.Students.Graduated.index',compact('students'));
    }

    public function create()
    {
        $Grades = Grade::all();
        return view('pages.Students.Graduated.create', compact('Grades'));
    }

    public function SoftDelete($request)
    {

        $students = Student::where('Grade_id', $request->Grade_id)->where('Classroom_id', $request->Classroom_id)
            ->where('section_id', $request->section_id)->get();

        if ($students->count() < 1) {
            return redirect()->back()->with('error_Graduated', __(trans('Students_trans.no_students')));
        }
        foreach ($students as $student) {
            $ids = explode(',', $student->id);
            Student::whereIn('id', $ids)->Delete();
        }
        toastr()->success(trans('messages.Success   '));
        return redirect()->route('Graduated.index');
    }
    public function ReturnData($request)
    {
        Student::onlyTrashed()->where('id',$request->id)->first()->restore();
        toastr()->success('messages.Success');
        return redirect()->back();
    }
    public function dsetroy($request)
    {
        Student::onlyTrashed()->where('id',$request->id)->first()->forceDelete();
        toastr()->success('messages.Delete');
        return redirect()->back();
    }
}
