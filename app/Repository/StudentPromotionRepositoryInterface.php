<?php

namespace App\Repository;

interface StudentPromotionRepositoryInterface
{
    public function index();
    public function create();

    public function store($request);
    public function destroy($request);


}
