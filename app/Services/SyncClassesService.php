<?php

namespace App\Services;

use App\Models\Classes;
use App\Models\Courses;
use App\Models\SchoolYears;

class SyncClassesService
{
    /**
     * @var string 
     */
    protected string $filePath = "bin\bookreq_classes.csv";

    public function readCSV(string $email, int $id){
        if(!file_exists($this->filePath)) {
            return;
        }

        $file = fopen($this->filePath, 'r');
        //get headers
        $header = fgetcsv($file);
        //loop through rows
        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);
            if($data["TEACHER: Email 1"] !== $email){
                continue;
            }
            $course = Courses::where('course_id', $data["Course ID"])->first();
            $year = SchoolYears::firstOrCreate(['year' => $data["School Year"]],
                [
                    'year' => $data["School Year"], 
                ]);
            Classes::firstOrCreate(['class_id' => $data["Class ID"], 'school_year'=> $year->id],
                [
                    'class_id' => $data["Class ID"],
                    'course_id' => $course->id,
                    'school_year'=> $year->id,
                    'teacher_id' => $id,
                    'students' => $data["Student Counts"],
                    'max' => $data["Max Students"],
                ]);
        }
    }   
}
