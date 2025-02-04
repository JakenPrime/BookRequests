<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequestUpdateRequest;
use App\Models\BookRequests;
use App\Models\Books;
use App\Repositories\BookRepository;
use App\Repositories\BookRequestsRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class BookRequestController extends Controller
{
    /**
     * @var BookRequestsRepository
     */
    private $requests;

    /**
     * @var BookRepository
     */
    private $books;

    /**
     * @var OrderRepository
     */
    private $orders;

    /**
     * @param BookRequestsRepository $repo
     * @param BookRepository $book
     * @param OrderRepository $orders
     */
    public function __construct(
        BookRequestsRepository $repo, 
        BookRepository $book,
        OrderRepository $orders
        ){
        $this->requests = $repo;
        $this->books = $book;
        $this->orders = $orders;
    }

    public function show(string $id): View
    {
        return view('book-request', [
            'book' => $this->requests->getBook($id),
            'request' => $this->requests->getRequest($id),            
        ]);
    }
    public function user(string $id):View {
        return view('user-request', [
            'books' => $this->requests->getUsersBooks($id),
            'request' => $this->orders->getUserOrder($id),            
        ]);
    }
    public function showClosed(string $id): View
    {
        return view('book-request', [
            'book' => $this->requests->getBook($id),
            'request' => $this->requests->getRequest($id),            
        ]);
    }

    public function update(BookRequestUpdateRequest $request, string $id)
    {
        foreach ($request->all() as $key => $value) {
            $data = json_decode($value);
            foreach($data as $item) {
                $req = BookRequests::where('book_id', $id)
                ->where('order_id', $item->id)
                ->first();

                $req->ordered = $item->ordered;
                $req->save();
            }
        }
    }

    public function updateUser(BookRequestUpdateRequest $request, string $id){
        foreach ($request->all() as $key => $value) {
            $data = json_decode($value);
            foreach($data as $item) {
                $req = BookRequests::where('book_id', $item->id)
                ->where('order_id', $id)
                ->first();

                $req->quantity = $item->quantity;
                $req->save();
            }
        }
    }

    public function shelfTag(string $id): View {
        return view('shelf-tag', [
            'book' => $this->books->getShelfTag($id),
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $bookReq = $request->bookReq();

        $bookReq->delete();

        return Redirect::to('/bookrequests');
    }
}
