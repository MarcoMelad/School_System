<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasTranslations;

    public $translatable = ['Name_Section'];
    protected $table = 'Sections';
    public $timestamps = true;
    protected $fillable = [
      'Name_Section',
      'Grade_id',
      'Class_id'
    ];

    public function My_Class()
    {
        return $this->belongsTo(Classroom::class,'Class_id');
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class,'teacher_section');
    }

    public function Grades()
    {
        return $this->belongsTo(Grade::class,'Grade_id');
    }

}
