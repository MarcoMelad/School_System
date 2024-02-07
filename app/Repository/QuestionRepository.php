<?php

namespace App\Repository;

use App\Models\Question;
use App\Models\Quizze;
use App\Repository\QuestionRepositoryInterface;

class QuestionRepository implements QuestionRepositoryInterface
{

    public function index()
    {
        $questions = Question::get();

        return view('pages.Questions.index',compact('questions'));
    }

    public function create()
    {
        $quizzes = Quizze::all();
        $question = Question::get();
        return view('pages.Questions.create',compact('question','quizzes'));
    }

    public function store($request)
    {
        try {

            $questions = new Question();
            $questions->title = $request->title;
            $questions->answers = $request->answers;
            $questions->right_answer = $request->right_answer;
            $questions->score = $request->score;
            $questions->quizze_id = $request->quizze_id;
            $questions->save();

            toastr()->success('messages.Success');
            return redirect()->route('questions.create');
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $quizzes = Quizze::all();
        $question = Question::findOrFail($id);
        return view('pages.Questions.edit',compact('question','quizzes'));
    }

    public function update($request)
    {
        try {

            $questions =  Question::findOrFail($request->id);
            $questions->title = $request->title;
            $questions->answers = $request->answers;
            $questions->right_answer = $request->right_answer;
            $questions->score = $request->score;
            $questions->quizze_id = $request->quizze_id;
            $questions->save();

            toastr()->success('messages.Update');
            return redirect()->route('questions.index');
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Question::destroy($request->id);

            toastr()->success('messages.Delete');
            return redirect()->back();
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
