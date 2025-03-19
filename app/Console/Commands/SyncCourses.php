<?php

namespace App\Console\Commands;

use App\Models\Courses;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncCourses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string 
     */
    protected string $filePath = "bin\bookreq_courses.csv";

    /**
     * Execute the console command.
     */
    public function handle(){
        if(!file_exists($this->filePath)){
            return;
        }

        $file = fopen($this->filePath, 'r');
        //get headers
        $header = fgetcsv($file);
        //loop through rows
        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);
            Courses::firstOrCreate(['course_id' => $data["Course ID"]], 
            [
                'course_id' => $data["Course ID"],
                'name' => $data["Description"],
                'department' => $data["Department"],
            ]);
        }

        // File::delete($this->filePath);
    }
}
