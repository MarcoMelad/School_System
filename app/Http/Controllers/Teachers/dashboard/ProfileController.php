<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $information = Teacher::where('id', auth()->user()->id)->first();
        return view('pages.Teachers.dashboard.profile', compact('information'));
    }

    public function update(Request $request, $id)
    {
        $information = Teacher::findorFail($id);

        if (!empty($request->password)) {
            $information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->password = Hash::make($request->password);
            $information->save();
        } else {
            $information->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $information->save();
        }
        toastr()->success(trans('messages.Update'));
        return redirect()->back();
    }
}
