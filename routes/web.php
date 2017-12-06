<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'TestController@index');

Route::post('/testPost', 'TestController@post');
Route::get('/testGet', 'TestController@get');


Route::get('/articlechanges', 'TestController@articleChanges');

Route::get('/getuserdata', 'ArticleController@getUserData'); //only used for testing remove if used for production

Route::post('/createarticle', 'ArticleController@createArticle');
Route::post('/editarticle', 'ArticleController@editArticleSave');
Route::post('/loadarticle', 'ArticleController@editArticleLoad');
Route::post('/submitarticleforreview', 'ArticleController@submitArticleForReview');
Route::post('/publisharticle', 'ArticleController@publishArticle');
Route::post('/deletearticle', 'ArticleController@deleteArticle');
Route::post('/pushbackarticle', 'ArticleController@pushbackArticle');



Route::get('/viewallarticles', 'ArticleController@viewAllArticles');
Route::get('/viewallpendingarticles', 'ArticleController@viewAllPendingArticles');
Route::get('/viewallpublishedarticles', 'ArticleController@viewAllPublishedArticles');
Route::get('/viewallyourarticles', 'ArticleController@viewAllYourArticles');


Route::post('/commentOnArticle', 'ArticleController@commentOnArticle');
Route::post('/deleteComment', 'ArticleController@deleteComment');
Route::post('/viewAllArticleComments', 'ArticleController@viewAllArticleComments');
Route::post('/likeComment', 'ArticleController@likeComment');
Route::post('/likeArticle', 'ArticleController@likeArticle');
