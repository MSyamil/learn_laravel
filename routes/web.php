<?php

use App\Http\Controllers\CookieController;
use App\Http\Controllers\HelloController;
use App\Http\Middleware\ContohMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// route
Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Hello World';
});

Route::redirect('/ancrit', '/hello');

// check all routes
// php artisan route:list

// if page not found
Route::fallback(function (){
    return '<h1>Page not found</h1>';
});

Route::view('/hello', 'hello', ['name' => 'Ancrit']);
// or 
Route::get('/hello-again', function () {
    return view('hello', ['name' => 'Dek']);
});

Route::view('/beliau', 'lapar.nich', ['name' => 'Kamal']);

// Route Parameter

Route::get('/products/{id}', function ($id) { 
    return "Product ID: $id";
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product: $productId, Item: $itemId";
})->name('product.item.detail');

Route::get('/category/{id}', function ($catId) { // regex
    return "Category ID: $catId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function ($userId = '404') { // optional parameter // default value is '404'
    return "User $userId";
})->name('user.detail');

// harus tau posisi
Route::get('/conflict/niv', function() { // conflict bawah
    return 'Conflict niv kaiser';
});

Route::get('/conflict/{name}', function ($name) { // conflict atas
    return "Conflict $name";
});

Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', ['id' => $id]);
    return "Link $link";
});

Route::get('/produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});

// ======pake controller======
Route::get('/controller/hello/request',[\App\Http\Controllers\HelloController::class, 'request']);
Route::get('/controller/hello/{name}',[\App\Http\Controllers\HelloController::class, 'hello']);

// inpuut
Route::get('/input/hello',[\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello',[\App\Http\Controllers\InputController::class, 'hello']);
Route::post('/input/hello/first',[\App\Http\Controllers\InputController::class, 'helloFirstName']);
Route::post('/input/hello/input',[\App\Http\Controllers\InputController::class, 'helloInput']);
Route::post('/input/hello/array',[\App\Http\Controllers\InputController::class, 'helloArray']);
Route::post('/input/type',[\App\Http\Controllers\InputController::class, 'inputType']);
Route::post('/input/filter/only',[\App\Http\Controllers\InputController::class, 'filterOnly']);
Route::post('/input/filter/except',[\App\Http\Controllers\InputController::class, 'filterExcept']);
Route::post('/input/filter/merge',[\App\Http\Controllers\InputController::class, 'filterMerge']);

// file
Route::post('/file/upload',[\App\Http\Controllers\FileController::class, 'upload'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

// response {
Route::get('/response/hello', [\App\Http\Controllers\ResponseController::class, 'response']);
Route::get('/response/header', [\App\Http\Controllers\ResponseController::class, 'header']);

//=================its called Route Group
Route::prefix("/response/type")->group(function (){
    Route::get('/view', [\App\Http\Controllers\ResponseController::class, 'responseView']);
    Route::get('/json', [\App\Http\Controllers\ResponseController::class, 'responseJson']);
    Route::get('/file', [\App\Http\Controllers\ResponseController::class, 'responseFile']);
    Route::get('/download', [\App\Http\Controllers\ResponseController::class, 'responseDownload']);
});
//}

// cookie
Route::controller(\App\Http\Controllers\CookieController::class)->group(function (){ //  =================group controller
    Route::get('/cookie/set', 'createCookie');
    Route::get('/cookie/get', 'getCookie');
    Route::get('/cookie/clear', 'clearCookie');
});

// redirect
Route::get('/redirect/from', [\App\Http\Controllers\RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [\App\Http\Controllers\RedirectController::class, 'redirectTo']);
Route::get('/redirect/name', [\App\Http\Controllers\RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [\App\Http\Controllers\RedirectController::class, 'redirectHello'])
    ->name('redirect-hello');
Route::get('/redirect/action', [\App\Http\Controllers\RedirectController::class, 'redirectAction']);
Route::get('/redirect/away', [\App\Http\Controllers\RedirectController::class, 'redirectAway']);

// middleware

// without parameter
// Route::get('/middleware/api', function(){
//     return 'Hello World';
// })->middleware(\App\Http\Middleware\ContohMiddleware::class);

// with parameter
// Route::get('/middleware/api', function(){
//     return 'Hello World';
// })->middleware(['contoh:guwah,401']);

// Route::get('/middleware/group', function(){
//     return 'Hello Group';
// })->middleware(['guwah']); // sebutkan nama groupnya

Route::middleware(['contoh:guwah,401'])->prefix('/middleware')->group(function (){ // =================group middleware //prefix untuk membuat awalan
    // without parameter
    // Route::get('/api', function(){
    // })->middleware(\App\Http\Middleware\ContohMiddleware::class);
    //     return 'Hello World';

    // with parameter
    Route::get('/api', function(){
    return 'Hello World';
    });
    
    Route::get('/group', function(){
    return 'Hello Group';
    }); 
});

// Cross siite request forgery
Route::get('/form',[\App\Http\Controllers\FormController::class, 'form']);
Route::post('/form',[\App\Http\Controllers\FormController::class, 'submitForm']);

// URL Generation
Route::get('/url/action', function () {
    // return action([App\Http\Controllers\FormController::class, 'form'], []);
    // return url()->action([App\Http\Controllers\FormController::class, 'form'], []);
    return \Illuminate\Support\Facades\URL::action([App\Http\Controllers\FormController::class, 'form'], []);
});

Route::get('/url/current', function (){
    return \Illuminate\Support\Facades\URL::full();
});

Route::get('/redirect/named', function (){
    // return route('redirect-hello', ['name' => 'Dek']);
    // return url()->route('redirect-hello', ['name' => 'Dek']);
    return  \Illuminate\Support\Facades\URL::route('redirect-hello', ['name' => 'Nivek']);
});

//Session
Route::get('/session/create', [\App\Http\Controllers\SessionController::class, 'createSession']);
Route::get('/session/get', [\App\Http\Controllers\SessionController::class, 'getSession']);

// Error handling
Route::get('/error/sample', function(){
    throw new Exception('Sample Error ');
});

Route::get('/error/manual', function(){
    report(new Exception('Sample Error'));
    return 'Error';
});

Route::get('/error/validation', function(){
    throw new \App\Exceptions\ValidationException('Validation Error');
});

//HTTP Exceptions
Route::get('/abort/400', function(){
    abort(400, 'Modol');
});

Route::get('/abort/401', function(){
    abort(401);
    return 'Unauthorized';
});

Route::get('/abort/403', function(){
    abort(403);
    return 'Forbidden';
});

Route::get('/abort/404', function(){
    abort(404);
    return 'Not Found';
});

Route::get('/abort/500', function(){
    abort(500);
    return 'Internal Server Error';
});