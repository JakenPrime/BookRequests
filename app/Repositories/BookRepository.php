<?php

namespace App\Repositories;

use App\Models\BookRequests;
use App\Models\Books;
use Illuminate\Support\Collection;
use stdClass;

class BookRepository
{
    /**
     * @var Collection
     */
    private $list;

    public function __construct() {
        $this->list = collect();
    }

    public function getShelfTag($id): stdClass{
        $book = Books::where('id', $id)->first();
        $obj = new stdClass();
        $obj->course = "class_data.course";
        $obj->name = "class_data.name";
        $obj->title = $book->title;
        $obj->teachers = array();
        $reqs = $book->requests;

        foreach($reqs as $item){
            $order = $item->requests;
            if($order->status == 2){
                $user = $order->teacher;
                $obj->teachers[] = $user->first_name ." ". $user->last_name;
            }
        }

        return $obj;
    }
}
