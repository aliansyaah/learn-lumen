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

// Run server: php -S localhost:9000 -t public

$app->get('/', function () use ($app) {
    // return $app->version();
    $res['success'] = true;
    $res['result'] = "Hello there welcome to web API using Lumen tutorial!";
    return response($res);
});

// Generate application key (APP_KEY)
$app->get('/generate-app-key', function () {
    return str_random(32);  // random string 32 karakter
});

// http://localhost:9000/hello
$app->get('/hello', function () use ($app) {
    /* "use" bukan suatu function, tetapi bagian dari closure sintax,
        dimana "use" ini dapat memanggil nilai di luar scope dari function atau 
        closure yg kita buat.
    */
    return "Hello World!";
});

// http://localhost:9000/posts/12/comments/84
$app->get('/posts/{postId}/comments/{commentsId}', function ($post_id, $comment_id) {
    return "Post: ".$post_id.", comment: ".$comment_id;
});

// =================== Contoh Route Groups =================== //

// Named Routes
// Memberikan alias pada route name
// Jika mengakses url "profile/user", akan tampil "Ini halaman profile user"
$app->get('profile/user', ['as' => 'route.profiles', function () {
    return "Ini halaman profile user";
}]);

// Atau bisa memberikan alias untuk controller action
// $app->get('profile/user', [
//     'as' => 'route.profiles', 'uses' => 'UserController@showProfile'
// ]);

// Jika mengakses url "profile", akan redirect ke route alias "route.profiles"
$app->get('profile', function () {
    return redirect()->route('route.profiles');
});

$app->get('/settings', ['as' => 'settings', 'uses' => 'ExampleController@getSettings']);
$app->get('/settings/photo', ['as' => 'settings.photo', 'uses' => 'ExampleController@getSettingsPhoto']);

// ========================== //

// Route Prefixes
// Semua route yg ada di dalam group ini akan diawali dgn prefix "admin"
$app->group(['prefix' => 'admin', 'middleware' => 'age'], function () use ($app) {
    // http://localhost:9000/admin/home
    $app->get('home', function () {
        return "Home Admin";
    });

    $app->get('profile', function () {
        return "Profile Admin";
    });

});

$app->get('age-fail', function () {
    return "Not yet mature";
});

// ========================== //

$app->get('foo/bar', 'ExampleController@fooBar');
$app->post('user/profile/request', 'ExampleController@userProfile');
$app->get('example-response', 'ExampleController@response');
$app->post('example-response', 'ExampleController@responsePost');
$app->post('example-response2', 'ExampleController@responsePost2'); // custom validation msg

// ============================================================ //
// ===================== Contoh eloquent ====================== //

$app->get('read-user-profile/{id}', 'ProfileController@read');
$app->get('read-profile/{phone}', 'ProfileController@readProfile');
$app->post('create-user-profile', 'ProfileController@create');

// ============================================================ //
// ================= Contoh route HTTP method ================= //

$app->get('/example-method', function () {
    return "Contoh method GET";
});
$app->post('/example-method', function () {
    return "Contoh method POST";
});
$app->put('/example-method', function () {
    return "Contoh method PUT";
});
$app->delete('/example-method', function () {
    return "Contoh method DELETE";
});
// ============================================================ //

$app->post('/register', 'UserController@register');
$app->post('/login', 'LoginController@index');
$app->get('/user/{id}', ['middleware' => 'auth', 'uses' => 'UserController@get_user']);

/* Route category */
/* Jika tdk pakai middleware auth di construct CategoryAdsController, 
    bisa pakai route group lalu assign middleware untuk semua routes.
*/
$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->get('/category', 'CategoryAdsController@index');
    $app->get('/category/{id}', 'CategoryAdsController@read');
    $app->post('/category', 'CategoryAdsController@create');
    $app->post('/category/update/{id}', 'CategoryAdsController@update');
    $app->post('/category/delete/{id}', 'CategoryAdsController@delete');
});

/* Route item_ads */
$app->get('/item_ads', 'ItemAdsController@index');
$app->get('/item_ads/{id}', 'ItemAdsController@read');
$app->post('/item_ads/create', 'ItemAdsController@create');
$app->post('/item_ads/update/{id}', 'ItemAdsController@update');
$app->post('/item_ads/delete/{id}', 'ItemAdsController@delete');