<?php

namespace App\Models;

use App\Http\Controllers\Students\ProcessingFeeController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class Student extends Authenticatable
{
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['name'];

    protected $guarded=[];

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }

    // علاقة بين الطلاب والمراحل الدراسية لجلب اسم المرحلة في جدول الطلاب

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }


    // علاقة بين الطلاب الصفوف الدراسية لجلب اسم الصف في جدول الطلاب

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
    }

    // علاقة بين الطلاب الاقسام الدراسية لجلب اسم القسم  في جدول الطلاب

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }
    public function Nationality()
    {
        return $this->belongsTo(Nationalitie::class,'nationalitie_id');
    }
    public function myparent()
    {
        return $this->belongsTo(my_Parent::class,'parent_id');
    }
    public function student_account()
    {
        return $this->hasMany(StudentAccount::class, 'student_id');
    }
    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance', 'student_id');
    }

}
