<?php

namespace App\Repository;

interface TeacherQuizzRepositoryInterface
{
    public function edit($id);
    public function show($id);
    public function index();
    public function crate();
    public function store($request);


    public function update($request);

    public function destroy($request);
}
