<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BookService {
    use ConsumeExternalService;

    public $baseUri;
    /**
     * @var \Laravel\Lumen\Application|mixed
     */
    private $secret;

    public function __construct()
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.authors.secret');
    }
    public function getBooks(){
        return $this->performRequest('GET','/books');
    }
    public function getBook($book){
        return $this->performRequest('GET',"/books/{$book}");
    }
    public function createBook($data) {
        return $this->performRequest('POST','/books',$data);
    }
    public function editBook($data, $book) {
        return $this->performRequest('PUT',"/books/{$book}",$data);
    }
    public function deleteBook($book) {
        return $this->performRequest('DELETE',"/books/{$book}");
    }
}
