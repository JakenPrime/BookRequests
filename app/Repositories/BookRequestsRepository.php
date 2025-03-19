<?php

namespace App\Repositories;

use App\Models\BookRequests;
use App\Models\Orders;
use App\Models\Books;
use Illuminate\Support\Collection;
use stdClass;

class BookRequestsRepository {

    /**
     * @var Collection
     */
    private $request;

    public function __construct() {
        $this->request = collect();
    }
    
    public function getBook(int $id): stdClass {
        $book = Books::where('id', $id)->first();
        $obj = new stdClass();

        $obj->id = $book->id;
        $obj->title = $book->title;
        $obj->isbn = $book->isbn;

        return $obj;
    }
       
    public function getRequest(int $id): Collection {
        $book = Books::where('id', $id)->first();
        $req = $book->requests;

        foreach($req as $item) {
            $order = $item->requests;
            if($order->status != 0 && $order->status != 1){
                continue;
            }
            $class = $order->class;
            $course = $class->course;
            $obj = new stdClass();
            $user = $order->teacher;

            $obj->id = $order->id;
            $obj->name = $user->first_name ." ". $user->last_name;
            $obj->class = $course->name;
            $obj->quantity = $item->quantity;
            $obj->ordered = $item->ordered;
            $obj->students = $class->students;
            $obj->max = $class->max;

            $this->request->push($obj);
        }

        return $this->request;
    }

    public function getUsersBooks($id): Collection {
        $reqs = BookRequests::where('order_id', $id)->get();

        foreach($reqs as $item) {
            $book = $item->books;
            $obj = new stdClass();

            $obj->id = $book->id;
            $obj->isbn = $book->isbn;
            $obj->title = $book->title;
            $obj->author = $book->author;
            $obj->publisher = $book->publisher;
            $obj->ordered = $item->ordered;
            $obj->quantity = $item->quantity;

            $this->request->push($obj);
        }
        return $this->request;
    }
}