<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['middleware' => 'auth:api'], function () use ($router){
    $router->get('/users/me','UsersController@me');
});

$router->group(['middleware' => 'client.credentials'], function () use ($router){
    $router->get('/authors','AuthorsController@index');
    $router->post('/authors','AuthorsController@store');
    $router->get('/authors/{author}','AuthorsController@show');
    $router->put('/authors/{author}','AuthorsController@update');
    $router->patch('/authors/{author}','AuthorsController@update');
    $router->delete('/authors/{author}','AuthorsController@destroy');

    $router->get('/books','BooksController@index');
    $router->post('/books','BooksController@store');
    $router->get('/books/{book}','BooksController@show');
    $router->put('/books/{book}','BooksController@update');
    $router->patch('/books/{book}','BooksController@update');
    $router->delete('/books/{book}','BooksController@destroy');

    $router->get('/users','UsersController@index');
    $router->post('/users','UsersController@store');
    $router->get('/users/{user}','UsersController@show');
    $router->put('/users/{user}','UsersController@update');
    $router->patch('/users/{user}','UsersController@update');
    $router->delete('/users/{user}','UsersController@destroy');
});
