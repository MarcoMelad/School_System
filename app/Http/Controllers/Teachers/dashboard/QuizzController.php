<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Quizze;
use App\Repository\TeacherQuizzRepository;
use App\Repository\TeacherQuizzRepositoryInterface;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class QuizzController extends Controller
{
    protected $TeacherQiiz;

    public function __construct(TeacherQuizzRepositoryInterface $quizzRepository)
    {
        return $this->TeacherQiiz = $quizzRepository;
    }

    public function index()
    {
        return $this->TeacherQiiz->index();
    }

    public function create()
    {
        return $this->TeacherQiiz->crate();
    }
    public function show($id)
    {
        return $this->TeacherQiiz->show($id);
    }

    public function store(Request $request)
    {
        return $this->TeacherQiiz->store($request);
    }


    public function edit($id)
    {
        return $this->TeacherQiiz->edit($id);
    }

    public function update(Request $request)
    {
        return $this->TeacherQiiz->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->TeacherQiiz->destroy($request);
    }
    public function student_quizze($quizze_id){
        return $this->TeacherQiiz->student_quizze($quizze_id);
    }
    public function repeat_quizze(Request $request){
        return $this->TeacherQiiz->repeat_quizze($request);
    }
}
