<?php

namespace App\Repository;

interface StudentRepositoryInterface{

    public function Get_Student();
    public function Edit_Student($id);
    public function Update_Student($request);
    public function Delete_Student($request);
    public function Show_Student($id);
    public function Create_Student();
    public function Store_Student($request);
    public function Upload_attachment($request);
    public function Download_attachment($studentsname, $filename);
    public function Delete_attachment($request);
}
