<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSections;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    public function index()
    {
        $Grades = Grade::with(['Sections'])->get();
        $list_Grades = Grade::all();
        $teachers = Teacher::all();
        return view('pages.Sections.Sections',compact('Grades','list_Grades','teachers'));

    }


    public function store(StoreSections $request)
    {
        try{
            $validate = $request->Validated();

            $Section = new Section();
            $Section->Name_Section = [
                'ar' => $request->Name_Section_Ar,
                'en' => $request->Name_Section_En,
            ];
            $Section->Grade_id = $request->Grade_id;
            $Section->Class_id = $request->Class_id;
            $Section->Status = 1;
            $Section->save();
            $Section->teachers()->attach($request->teacher_id);

            toastr()->success(trans('messages.Success'));
            return redirect()->route('Sections.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(StoreSections $request)
    {
        try{
            $validate = $request->validated();
            $Section = Section::findOrFail($request->id);

            $Section->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En];
            $Section->Grade_id = $request->Grade_id;
            $Section->Class_id = $request->Class_id;

            if (isset($request->Status)){
                $Section->Status = 1 ;
            }else {
                $Section->Status = 2;
            }
            if (isset($request->teacher_id)) {
                $Section->teachers()->sync($request->teacher_id);
            } else {
                $Section->teachers()->sync(array());
            }
            $Section->save();

            toastr()->success(trans('messages.Update'));
            return redirect()->route('Sections.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $Sections = Section::findOrFail($request->id)->delete();
        toastr()->success(trans('messages.Delete'));
        return redirect()->route('Sections.index');

    }

    public function getclasses($id)
    {
        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name_Class", "id");

        return $list_classes;
    }

}
