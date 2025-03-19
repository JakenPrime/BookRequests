<?php

namespace App\Repositories;

use App\Models\Classes;
use Illuminate\Support\Collection;
use stdClass;

class ClassRepository
{
    /**
     * @var Collection
     */
    private $list;

    public function __construct() {
        $this->list = collect();
    }

    public function getClasses($id): Collection {
        $classes = Classes::where('teacher_id', $id)->get();
        if($classes->count() == 0) return $classes;

        foreach($classes as $item) {
            $obj = new stdClass();
            $course = $item->course;

            $obj->id = $item->id;
            $obj->class_id = $item->class_id;
            $obj->name = $course->name;

            $this->list->push($obj);
        }
        return $this->list;
    }
}
