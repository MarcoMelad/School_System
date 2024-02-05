<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promotion extends Model
{
    protected $guarded=[];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
    public function f_grade()
    {
        return $this->belongsTo(Grade::class,'from_grade');
    }
    public function f_classroom()
    {
        return $this->belongsTo(Classroom::class,'from_Classroom');
    }
    public function f_section()
    {
        return $this->belongsTo(Section::class,'from_section');
    }
    public function t_grade()
    {
        return $this->belongsTo(Grade::class,'to_grade');
    }
    public function t_classroom()
    {
        return $this->belongsTo(Classroom::class,'to_Classroom');
    }
    public function t_section()
    {
        return $this->belongsTo(Section::class,'to_section');
    }

}
