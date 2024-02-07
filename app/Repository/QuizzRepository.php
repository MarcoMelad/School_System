<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\Quizze;
use App\Models\Subject;
use App\Models\Teacher;
use App\Repository\QuizzRepositoryInterface;

class QuizzRepository implements QuizzRepositoryInterface
{

    public function index()
    {
        $quizzes = Quizze::all();
        return view('pages.Quizzes.index',compact('quizzes'));
    }

    public function create()
    {
        $data['grades'] = Grade::get();
        $data['teachers'] = Teacher::get();
        $data ['subjects'] = Subject::get();
        return view('pages.Quizzes.create', $data);
    }

    public function store($request)
    {

        try {
            $quizzes  = new Quizze();
            $quizzes->name = ['en'=> $request->Name_en,'ar'=> $request->Name_ar];
            $quizzes ->subject_id = $request->subject_id;
            $quizzes ->grade_id = $request->Grade_id;
            $quizzes ->classroom_id = $request->Classroom_id;
            $quizzes->section_id = $request->section_id;
            $quizzes->teacher_id = $request->teacher_id;
            $quizzes->save();

            toastr()->success('messages.Success');
            return redirect()->route('Quizzes.create');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $quizz = Quizze::findOrfail($id);
        $data['grades'] = Grade::get();
        $data['teachers'] = Teacher::get();
        $data ['subjects'] = Subject::get();
        return view('pages.Quizzes.edit', $data,compact('quizz'));
    }

    public function update($request)
    {
        try {
            $qizz = Quizze::findOrFail($request->id);
            $qizz->name = ['en'=>$request->Name_en,'ar'=>$request->Name_ar];
            $qizz->subject_id = $request->subject_id;
            $qizz->grade_id = $request->Grade_id;
            $qizz->classroom_id = $request->Classroom_id;
            $qizz->section_id = $request->section_id;
            $qizz->teacher_id = $request->teacher_id;
            $qizz->save();

            toastr()->success('messages.Update');
            return redirect()->route('Quizzes.index');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Quizze::destroy($request->id);
            toastr()->success('messages.Delete');
            return redirect()->back();

        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
