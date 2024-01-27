<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Grade;


class Classroom extends Model
{

    use HasTranslations;
    public $translatable = ['Name_Class'];
    protected $fillable = [
        'Name_Class',
        'Grade_id'
    ];

    protected $table = 'Classrooms';
    public $timestamps = true;

    public function Grades()
    {
        return $this->belongsTo(Grade::class, 'Grade_id');
    }

}
