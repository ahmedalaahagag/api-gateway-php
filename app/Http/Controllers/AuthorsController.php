<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use App\Services\AuthorService;

class AuthorsController extends Controller
{
    use ApiResponder;

    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index() :JsonResponse
    {
        return $this->validResponse($this->authorService->getAuthors());
    }

    public function store(Request $request) :JsonResponse
    {
        return $this->validResponse($this->authorService->createAuthor($request->all()));
    }

    public function show($author) :JsonResponse
    {
        return $this->validResponse($this->authorService->getAuthor($author));
    }

    public function update(Request $request, $author) :JsonResponse
    {
        return $this->validResponse($this->authorService->editAuthor(($request->all()),
            $author));
    }

    public function destroy($author) :JsonResponse
    {
        return $this->validResponse($this->authorService->deleteAuthor($author));
    }
}
