<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\promotion;
use App\Models\Student;
use App\Repository\StudentPromotionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StudentPromotionRepository implements StudentPromotionRepositoryInterface
{

    public function index()
    {
        $Grades = Grade::all();
        return view('pages.Students.promotion.index', compact('Grades'));
    }

    public function create()
    {
        $promotions = promotion::all();

        return view('pages.Students.promotion.management', compact('promotions'));
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {
            $students = Student::where('Grade_id', $request->Grade_id)
                ->where('Classroom_id', $request->Classroom_id)->where('section_id', $request->section_id)
                ->where('academic_year', $request->academic_year)->get();

            if ($students->count() < 1) {
                return redirect()->back()->with('error_promotions', __(trans('Students_trans.no_students')));
            }

            foreach ($students as $student) {
                $ids = explode(',', $student->id);
                Student::whereIn('id', $ids)->update([
                    'Grade_id' => $request->Grade_id_new,
                    'Classroom_id' => $request->Classroom_id_new,
                    'section_id' => $request->section_id_new,
                    'academic_year' => $request->academic_year_new,
                ]);


                promotion::updateOrCreate([
                    'student_id' => $student->id,
                    'from_grade' => $request->Grade_id,
                    'from_Classroom' => $request->Classroom_id,
                    'from_section' => $request->section_id,
                    'to_grade' => $request->Grade_id_new,
                    'to_Classroom' => $request->Classroom_id_new,
                    'to_section' => $request->section_id_new,
                    'academic_year' => $request->academic_year,
                    'academic_year_new' => $request->academic_year_new
                ]);
            }
            DB::commit();
            toastr()->success(trans('messages.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function destroy($request)
    {
        DB::beginTransaction();

        try {

            if ($request->page_id == 1) {

                $promotions = promotion::all();

                foreach ($promotions as $promotion) {

                    $ids = explode(',', $promotion->student_id);
                    Student::whereIn('id', $ids)->update([
                        'Grade_id' => $promotion->from_grade,
                        'Classroom_id' => $promotion->from_Classroom,
                        'section_id' => $promotion->from_section,
                        'academic_year' => $promotion->academic_year,
                    ]);

                    promotion::truncate();
                }
                DB::commit();
                toastr()->success(trans('messages.Delete'));
                return redirect()->back();

            } else {

                $Promotion = promotion::findOrFail($request->id);
                Student::where('id', $Promotion->student_id)->update([
                    'Grade_id' => $Promotion->from_grade,
                    'Classroom_id' => $Promotion->from_Classroom,
                    'section_id' => $Promotion->from_section,
                    'academic_year' => $Promotion->academic_year,
                ]);
                promotion::destroy($request->id);
                DB::commit();
                toastr()->success(trans('messages.Delete'));
                return redirect()->back();
            }


        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

}
