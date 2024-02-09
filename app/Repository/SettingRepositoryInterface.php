<?php

namespace App\Repository;

interface SettingRepositoryInterface
{
    public function index();
    public function update($request);
    public function destroy($request);

}
