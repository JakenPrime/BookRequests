<?php

namespace App\Repositories;

use App\Models\BookRequests;
use App\Models\Notes;
use App\Models\Orders;
use Illuminate\Support\Collection;
use stdClass;

class OrderRepository
{
    /**
     * @var Collection
     */
    private $list;

    /**
     * @var Collection
     */
    private $openOrders;

    /**
     * @var Collection
     */
    private $pendingOrders;

    /**
     * @var Collection
     */
    private $completedOrders;

    public function __construct() {
        $this->list = collect();
        $this->openOrders = collect();
        $this->pendingOrders = collect();
        $this->completedOrders = collect();
    }
        

    public function getOpenOrders(): Collection {
        $orders = Orders::where('status', 0)->get();
        if($orders->count() == 0) return $orders;

        foreach($orders as $item) {
            $requests = $item->bookRequests;
            foreach($requests as $req){
                $obj = new stdClass();
                $book = $req->books;

                $obj->id = $book->id;
                $obj->title = $book->title;
                $obj->quantity = $req->quantity;

                $this->openOrders->push($obj);
            }
        }
        return $this->openOrders; 
    }

    public function getPendingOrders(): Collection {
        $orders = Orders::where('status', 1)->get();
        if($orders->count() == 0) return $orders;

        foreach($orders as $item) {
            $requests = $item->bookRequests;
            foreach($requests as $req){
                $book = $req->books;
                $obj = new stdClass();

                $obj->id = $book->id;
                $obj->title = $book->title;
                $obj->quantity = $req->quantity;
                $obj->ordered = $req->ordered;

                $this->pendingOrders->push($obj);
            }
        }
        return $this->pendingOrders;
    }

    public function getCompletedOrders(): Collection {
        $orders = Orders::where('status', 2)->get();
        if($orders->count() == 0) return $orders;

        foreach($orders as $item) {
            $requests = $item->bookRequests;
            foreach($requests as $req){
                $book = $req->books;
                $obj = new stdClass();

                $obj->id = $req->order_id;
                $obj->book = $book->id;
                $obj->title = $book->title;
                $obj->quantity = $req->quantity;
                $obj->ordered = $req->ordered;

                $this->completedOrders->push($obj);
            }
        }

        return $this->completedOrders;
    }

    public function getOrder($id): stdClass {
        $obj = new stdClass();
        $order = Orders::where('id', $id)->first();
        $user = $order->teacher;
        $note = Notes::find($order->notes_id);

        $obj->id = $id;
        $obj->status = $order->status;
        $obj->name = $user->first_name ." ". $user->last_name;
        $obj->notes = $note ? $note->notes : '';
        return $obj;
    }

    public function getBooks($id): Collection {
        $requests = BookRequests::where('order_id', $id)->get(); 
        foreach ($requests as $req){
            $obj = new stdClass();
            $book = $req->books;

            $obj->id = $book->id;
            $obj->isbn = $book->isbn;
            $obj->title = $book->title;
            $obj->author = $book->author;
            $obj->publisher = "publisher.data";
            $obj->quantity = $req->quantity;
            $obj->ordered = $req->ordered;
            
            $this->list->push($obj);
        }
        return $this->list;
    }

    public function getUserRequests($id): Collection {
        $orders = Orders::where('user_id', $id)->get();

        foreach($orders as $item){
            $obj = new stdClass();
            $req = $item->bookRequests;
            
            $class = $item->class;
            $course = $class->course;

            $obj->id = $item->id;
            $obj->status = $item->getStatus();
            $obj->class = $course->name;
            $obj->titles = $req->count();
            $this->list->push($obj);
        }
        return $this->list;
    }

    public function getUserOrder(int $id): stdClass {
        $obj = new stdClass();
        $order = Orders::where('id', $id)->first();

        $obj->id = $order->id;
        $obj->status = $order->status;
        $obj->statusName = $order->getStatus();

        return $obj;
    }

    public function updateNotes($id, $data){
        $order = Orders::find($id);
        if(!$order->notes_id) {
           $noteID = $this->createNotes($data);
           $order->notes_id = $noteID;
           $order->save();
           return;
        }
        $note = Notes::find($order->notes_id);
        $note->notes = $data;
        $note->save();
    }

    public function createNotes($data): int{
        $note = Notes::create([
            'notes' => $data,
        ]);
        return $note->id;
    }
}
