<?php

namespace App\Repository;

interface StudentGraduatedRepositoryInterface
{
    public function index();
    public function create();
    public function SoftDelete($request);
    public function ReturnData($request);
    public function dsetroy($request);
}
