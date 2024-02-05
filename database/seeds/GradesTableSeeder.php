<?php

use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('Grades')->delete();

        $grades = [
            ['en'=> 'Primary Stage', 'ar'=> 'المرحلة الابتدائية'],
            ['en'=> 'Middle Stage', 'ar'=> 'المرحلة الاعدادية'],
            ['en'=> 'High School', 'ar'=> 'المرحلة الثانوية'],

        ];
        foreach ($grades as $grade) {
            Grade::create(['Name' => $grade]);
        }
    }
}
