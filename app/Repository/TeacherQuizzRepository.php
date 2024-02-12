<?php

namespace App\Repository;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Question;
use App\Models\Quizze;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;

class TeacherQuizzRepository implements TeacherQuizzRepositoryInterface
{

    public function index()
    {
        $quizzes = Quizze::where('teacher_id', auth()->user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.index', compact('quizzes'));
    }

    public function crate()
    {
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::where('teacher_id', auth()->user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.create', $data);
    }

    public function getClassrooms($id)
    {
        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");
        return $list_classes;
    }

    //Get Sections
    public function Get_Sections($id)
    {

        $list_sections = Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }

    public function store($request)
    {

        try {
            $quizzes = new Quizze();
            $quizzes->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizzes->subject_id = $request->subject_id;
            $quizzes->grade_id = $request->Grade_id;
            $quizzes->classroom_id = $request->Classroom_id;
            $quizzes->section_id = $request->section_id;
            $quizzes->teacher_id = auth()->user()->id;
            $quizzes->save();
            toastr()->success(trans('messages.Success'));
            return redirect()->route('quizzes.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $quizz = Quizze::findorFail($id);
        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::where('teacher_id', auth()->user()->id)->get();
        return view('pages.Teachers.dashboard.Quizzes.edit', $data, compact('quizz'));
    }

    public function update($request)
    {
        try {
            $qizz = Quizze::findOrFail($request->id);
            $qizz->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $qizz->subject_id = $request->subject_id;
            $qizz->grade_id = $request->Grade_id;
            $qizz->classroom_id = $request->Classroom_id;
            $qizz->section_id = $request->section_id;
            $qizz->teacher_id = auth()->user()->id;
            $qizz->save();

            toastr()->success('messages.Update');
            return redirect()->route('quizzes.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Quizze::destroy($request->id);
            toastr()->success('messages.Delete');
            return redirect()->back();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $questions = Question::where('quizze_id',$id)->get();
        $quizz = Quizze::findOrFail($id);
        return view('pages.Teachers.dashboard.Questions.index',compact('questions','quizz'));
    }
}
