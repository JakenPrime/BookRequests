<?php

namespace App\Console\Commands;

use App\Models\Classes;
use App\Models\Courses;
use App\Models\SchoolYears;
use App\Models\User;
use Illuminate\Console\Command;

class SyncClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-classes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string 
     */
    protected string $filePath = "bin\bookreq_classes.csv";

    /**
     * Execute the console command.
     */
    public function handle() {
        if(!file_exists($this->filePath)) {
            return;
        }

        $file = fopen($this->filePath, 'r');
        //get headers
        $header = fgetcsv($file);
        //loop through rows
        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);
            $teacher = User::where('email', $data["TEACHER: Email 1"])->first();
            if($teacher == null){
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
                    'teacher_id' => $teacher->id,
                    'students' => $data["Student Counts"],
                    'max' => $data["Max Students"],
                ]);
        }
    }
}
