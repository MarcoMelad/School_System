<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStudent extends Model
{
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
