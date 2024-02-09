<?php

namespace App\Repository;

use App\Http\Traits\AttachFilesTrait;
use App\Models\Setting;
use App\Repository\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{

    use AttachFilesTrait;
    public function index()
    {
        $collection = Setting::all();

        $setting['setting'] = $collection->flatMap(function ($collection){
            return [$collection->key => $collection->value];
        });

        return view('pages.setting.index', $setting);
    }

    public function update($request)
    {
        try {
            $info = $request->except('_token','_method','logo');

            foreach ($info as $key=> $value) {
                Setting::where('key',$key)->update(['value'=> $value]);
            }

            if ($request->hasFile('logo')){
//                foreach ($request->file('logo') as $file) {
                    $logo_name = $request->file('logo')->getClientOriginalName();
                    Setting::where('key','logo')->update(['value'=> $logo_name]);
                    $this->uploadFile($request,'logo','Logo');
//                }
            }

            toastr()->success('messages.Update');
            return back();

        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        // TODO: Implement destroy() method.
    }
}
