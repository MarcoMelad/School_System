<?php

namespace App\Http\Controllers\Grades;

use App\Http\Requests\StoreGrades;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class GradeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   *
   */
  public function index()
  {
      $Grades = Grade::all();
    return view('pages.Grades.Grades', compact('Grades'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreGrades $request)
  {
      try {

      $validate = $request->validated();

      $Grade = new Grade();
      $Grade->Name = [
          'en' => $request->Name_en,
          'ar'=> $request->Name
      ];
      $Grade->Notes = $request->Notes;
      $Grade->save();
      toastr()->success(trans('message.success'));

      return redirect()->route('Grades.index');

      } catch (\Exception $e){
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(StoreGrades $request)
  {
      try {

      $validate = $request->validated();

      $Grade = Grade::findOrFail($request->id);
      $Grade->update([
          $Grade->Name = [
              'en' => $request->Name_en,
              'ar'=> $request->Name
          ],
          $Grade->Notes = $request->Notes
      ]);

          toastr()->success(trans('message.Update'));

          return redirect()->route('Grades.index');

      } catch (\Exception $e){
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
      }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request)
  {

          $Grade = Grade::findOrFail($request->id)->delete();
          toastr()->success(trans('message.Delete'));

          return redirect()->route('Grades.index');

  }

}

?>
