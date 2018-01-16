<?php
// Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//     // var_dump($query);
//     var_dump($query->sql); // Dumps sql
//     // var_dump($query->bindings); //Dumps data passed to query
//     var_dump($query->time); //Dumps time sql took to be processed
//  });

$router->post('login', 'AuthController@login');
$router->post('register', 'AuthController@register');
$router->post('logout', ['middleware' => 'auth', 'AuthController@logout']);

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('posts', 'PostsController@index');

    $router->get('posts/{id}', ['as' => 'article', 'uses' => 'PostsController@show']);

    $router->get('category/{name}', 'PostsController@byCategory');

    $router->post('comments', 'CommentsController@store');

    $router->get('comments/{id}', 'CommentsController@show');

    $router->get('categories', 'CategoriesController@index');

    $router->group(['middleware' => 'auth'], function ($router) {

        $router->get('users[/{id}]', function ($id = null) {
            return "You got $id...";
        });
        
        $router->post('posts', 'PostsController@store');
    
        $router->put('posts/{id}', 'PostsController@update');
    
        $router->delete('posts/{id}', 'PostsController@delete');

        $router->post('posts/{id}/restore', 'PostsController@restore');
    
        $router->patch('comments/{id}', function ($id) {
            return "Comment $id saved.";
        });
    
        $router->delete('comments/{id}', function ($id) {
            return "Comment $id deleted.";
        });

    });

});

$router->get('/', function () use ($router) {
    return view('welcome');
});
