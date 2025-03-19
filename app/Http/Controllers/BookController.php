<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookUpdateRequest;
use App\Models\Books;
use App\Repositories\ClassRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * @var ClassRepository
     */
    private $classes;

    /**
     * @param ClassRepository $classes
     */
    public function __construct(ClassRepository $classes) { 
        $this->classes = $classes;
    }

    public function show(): View
    {
        return view('books', [
            'bookList'=> Books::get(),
            'classList' => $this->classes->getClasses(Auth::user()->id),
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
