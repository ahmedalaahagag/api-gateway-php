<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class BooksController extends Controller
{
    use ApiResponder;

    public $bookService;
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @param BookService   $bookService
     * @param AuthorService $authorService
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index() :JsonResponse
    {
        return $this->successResponse($this->bookService->getBooks());
    }

    public function store(Request $request) :JsonResponse
    {
        $this->authorService->getAuthor($request->author_id);

        return $this->successResponse($this->bookService->createBook($request->all()));
    }

    public function show($book) :JsonResponse
    {
        return $this->successResponse($this->bookService->getBook($book));
    }

    public function update(Request $request, $book) :JsonResponse
    {
        return $this->successResponse($this->bookService->editBook(($request->all()),
            $book));
    }

    public function destroy($book) :JsonResponse
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
