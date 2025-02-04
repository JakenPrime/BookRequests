<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookUpdateRequest;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{

    public function show(): View
    {
        return view('books', [
            'bookList'=> Books::get(),
        ]);
    }

    public function store(BookUpdateRequest $request): View {
        Books::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'isbn' => $request->isbn,
        ]);

        return view('books', [
            'bookList'=> Books::get(),
        ]);
    }

    /**
     * Update the book's information.
     */
    public function update(BookUpdateRequest $request): View
    {
        $request->book()->fill($request->validated());

        $request->book()->save();

        return view('books', [
            'bookList'=> Books::get(),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): View
    {
        $book = $request->book();

        $book->delete();

        return view('books', [
            'bookList'=> Books::get(),
        ]);
    }
}
