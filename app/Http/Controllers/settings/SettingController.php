<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Repository\SettingRepositoryInterface;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $setting;

    public function __construct(SettingRepositoryInterface $setting)
    {
        return $this->setting = $setting;
    }

    public function index()
    {
        return $this->setting->index();
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        return $this->setting->update($request);
    }

    public function destroy($id)
    {
        //
    }
}
