<?php

namespace App\Repository;

use App\Models\Exam;
use App\Models\Student;
use App\Repository\ExamRepositoryInterface;

class ExamRepository implements ExamRepositoryInterface
{

    public function index()
    {
        $exams = Exam::get();
        return view('pages.Exams.index', compact('exams'));
    }

    public function create()
    {
        return view('pages.Exams.create');
    }

    public function store($request)
    {
        try {
            $exam = new Exam();
            $exam->name = ['en'=>$request->Name_en,'ar'=>$request->Name_ar];
            $exam->term = $request->term;
            $exam->academic_year = $request->academic_year;
            $exam->save();

            toastr()->success('messages.Success');
            return redirect()->route('Exams.create');
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $exam = Exam::findOrFail($id);
        return view('pages.Exams.edit',compact('exam'));
    }

    public function update($request)
    {
        try {
            $exam = Exam::findOrFail($request->id);
            $exam->name = ['en'=>$request->Name_en,'ar'=>$request->Name_ar];
            $exam->term = $request->term;
            $exam->academic_year = $request->academic_year;
            $exam->save();

            toastr()->success('messages.Update');
            return redirect()->route('Exams.index');
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Exam::destroy($request->id);
            toastr()->success('messages.Delete');
            return redirect()->back();
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
