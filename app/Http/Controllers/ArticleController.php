<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Auth;
use App\Classes\UserManager;
use Gate;
use Carbon\Carbon;
use App\Comment;
use App\Like;

const TEMP_USER_ID = 1;
class ArticleController extends Controller
{

  public function __construct()
  {
    //$this->middleware('auth');
  }

  public function getUserData()
  {
    $user = \App\User::where('id', TEMP_USER_ID)->first();
    $data = [];
    $data['permissions'] = unserialize($user->permissions);
    $data['user_id'] = TEMP_USER_ID;
    $data['name'] = $user->name;
    $data['email'] = $user->email;
    return json_encode($data);
  }

  public function createArticle(Request $request)
  {
    // if (Gate::denies('createArticle'))
    // {
    //     return view('authorizationError');
    // }
    $article = new Article();
    $article->name = $request->name;
    $article->teaser = $request->teaser;
    $article->content = $request->content;
    $article->published = false;
    $article->user_id = TEMP_USER_ID;//Auth::user()->id;
    $article->save();
    $value = $article->id;
    return '{ "id":"'.$value.'"}';
          // return view('Test/testIndex');
  }
  //requires the user to be the creator of the article, or a editor and the article is up for publishing
  public function editArticleSave(Request $request) //called when the user has finished editing article
  {
    $article = \App\Article::where('id', $request->articleID)->first();
    if ($article == null) // || Gate::denies('editArticle', $article))
    {
        $value = 'article not found';
        return '{ "error":"'.$value.'"}'; //view('authorizationError');
    }
    $article->name = $request->name;
    $article->teaser = $request->teaser;
    $article->content = $request->content;
    $article->save();
    $value = 'article saved';
    return '{ "result":"'.$value.'"}';
  }
  public function editArticleLoad(Request $request)
  {
    $article = \App\Article::where('id', $request->articleID)->first();
    if ($article == null) // || Gate::denies('editArticle', $article))
    {
        $value = 'article not found';
        return '{ "error":"'.$value.'"}'; //view('authorizationError');
    }
    $data = null;
    $data['id'] = $article['id'];
    $data['created_at'] = $article['created_at'];
    $data['updated_at'] = $article['updated_at'];
    $data['name'] = $article['name'];
    $data['teaser'] = $article['teaser'];
    $data['content'] = $article['content'];
    $data['author'] = UserManager::getUserWithID($article->user_id)->name;
    $data['published'] = $article['published'];

    return json_encode($data);
  }
  public function submitArticleForReview(Request $request)
  {
    $article = \App\Article::where('id', $request->articleID)->get()->first();
    if ($article == null) // || Gate::denies('submitArticleForReview', $article))
    {
      $value = 'article not found';
      return '{ "error":"'.$value.'"}'; //view('authorizationError');
    }
    $article->published = 1;
    $article->published_date = Carbon::now();
    $article->save();
    $value = 'article submited for review';
    return '{ "result":"'.$value.'"}';
  }
  public function deleteArticle(Request $request)
  {
    $article = \App\Article::where('id', $request->articleID)->first();
    if ($article == null) // || Gate::denies('deleteArticle', $article))
    {
      $value = 'article not found';
      return '{ "error":"'.$value.'"}'; //view('authorizationError');
    }
    $article->delete();
    $value = 'article deleted';
    return '{ "result":"'.$value.'"}';
  }
  public function publishArticle(Request $request) //requires the user to be an editor
  {
    $article = \App\Article::where('id', $request->articleID)->get()->first();
    if ($article == null) // || Gate::denies('publishArticle', $article))
    {
      $value = 'article not found';
      return '{ "error":"'.$value.'"}'; //view('authorizationError');
    }
    $article->published = 2;
    $article->published_date = Carbon::now();
    $article->save();
    $value = 'article published';
    return '{ "result":"'.$value.'"}';
  }
  public function pushbackArticle(Request $request)
  {
    $article = \App\Article::where('id', $request->articleID)->get()->first();
    if ($article == null) // || Gate::denies('pushbackArticle', $article))
    {
      $value = 'article not found';
      return '{ "error":"'.$value.'"}'; //view('authorizationError');
    }
    $article->published = 0;
    $article->published_date = Carbon::now();
    $article->save();
    $value = 'article pushed back';
    return '{ "result":"'.$value.'"}';
  }

  public function viewAllArticles() //requires the user to be an editor
  {
    // if (Gate::denies('viewPendingArticles'))
    // {
    //     return view('authorizationError');
    // }
    $articles = \App\Article::all();
    $data = null;
    foreach ($articles as $key => $article) {
      $data[$key]['id'] = $article['id'];
      $data[$key]['created_at'] = $article['created_at'];
      $data[$key]['updated_at'] = $article['updated_at'];
      $data[$key]['name'] = $article['name'];
      $data[$key]['teaser'] = $article['teaser'];
      $data[$key]['content'] = $article['content'];
      $data[$key]['author'] = UserManager::getUserWithID($article->user_id)->name;
      $data[$key]['published'] = $article['published'];
      $data[$key]['published_date'] = $article['published_date'];
    }
    return json_encode($data);
  }
  public function viewAllPendingArticles() //requires the user to be an editor
  {
    // if (Gate::denies('viewPendingArticles'))
    // {
    //     return view('authorizationError');
    // }

    $articles = \App\Article::where('published', 1)->get();
    $data = null;
    foreach ($articles as $key => $article) {
      $data[$key]['id'] = $article['id'];
      $data[$key]['created_at'] = $article['created_at'];
      $data[$key]['updated_at'] = $article['updated_at'];
      $data[$key]['name'] = $article['name'];
      $data[$key]['teaser'] = $article['teaser'];
      $data[$key]['content'] = $article['content'];
      $data[$key]['author'] = UserManager::getUserWithID($article->user_id)->name;
      $data[$key]['published_date'] = $article['published_date'];
    }
    return json_encode($data);
  }
  public function viewAllYourArticles() //requires the user to be an editor
  {
    $articles = \App\Article::where('user_id', TEMP_USER_ID)->get();
    $data = null;
    foreach ($articles as $key => $article) {
      $data[$key]['id'] = $article['id'];
      $data[$key]['created_at'] = $article['created_at'];
      $data[$key]['updated_at'] = $article['updated_at'];
      $data[$key]['name'] = $article['name'];
      $data[$key]['teaser'] = $article['teaser'];
      $data[$key]['content'] = $article['content'];
      $data[$key]['author'] = UserManager::getUserWithID($article->user_id)->name;
      $data[$key]['published'] = $article['published'];
      $data[$key]['published_date'] = $article['published_date'];
    }
    return json_encode($data);
  }
  public function viewAllPublishedArticles()
  {
    $articles = \App\Article::where('published', 2)->get();
    $data = null;
    foreach ($articles as $key => $article) {
      $data[$key]['id'] = $article['id'];
      $data[$key]['created_at'] = $article['created_at'];
      $data[$key]['updated_at'] = $article['updated_at'];
      $data[$key]['name'] = $article['name'];
      $data[$key]['teaser'] = $article['teaser'];
      $data[$key]['content'] = $article['content'];
      $data[$key]['author'] = UserManager::getUserWithID($article->user_id)->name;
      $data[$key]['user_id'] = $article['user_id'];
      $data[$key]['published_date'] = $article['published_date'];
      $data[$key]['likes'] = $article->likes()->count();
      $like = false;
      if($article->likes()->where('user_id', TEMP_USER_ID)->first() != null)
        $like = true;
      $data[$key]['like'] = $like;
    }
    return json_encode($data);
  }

  public function commentOnArticle(Request $request)
  {
    if($request->comment_id == null)
    {
      $article = \App\Article::where('id', $request->article_id)->first();
      $newComment = new Comment();
      $newComment->content = $request->content;
      $newComment->user_id = TEMP_USER_ID;
      $article->comments()->save($newComment);


      $value = $newComment->id;
      return '{ "result":"'.$value.'"}';
    }
    else
    {
      $comment = \App\Article::where('id', $request->article_id)->first()->comments()->where('id', $request->comment_id)->first();
      $comment->content = $request->content;
      $comment->save();

      $value = 'saved';
      return '{ "result":"'.$value.'"}';
    }
  }
  public function deleteComment(Request $request)
  {
    $comment = \App\Article::where('id', $request->article_id)->first()->comments()->where('id', $request->comment_id)->first();
    if ($comment == null)
    {
      $value = 'comment not found';
      return '{ "error":"'.$value.'"}';
    }
    $comment->delete();

    $value = 'article deleted';
    return '{ "result":"'.$value.'"}';
  }
  public function likeComment(Request $request)
  {
    if($request->value == 1) //like comment
    {
      $comment = \App\Comment::where('id', $request->comment_id)->first();
      if($comment->likes()->where('user_id', TEMP_USER_ID)->first() != null)
      {
        $value = 'error comment already liked';
        return '{ "result":"'.$value.'"}';
      }
      $newLike = new Like();
      $newLike->user_id = TEMP_USER_ID;
      $comment->likes()->save($newLike);
      $value = 'liked comment';
      return '{ "result":"'.$value.'"}';
    }
    else if($request->value == -1) //unlike comment
    {
      $comment = \App\Comment::where('id', $request->comment_id)->first();
      if($comment->likes()->where('user_id', TEMP_USER_ID)->first() == null)
      {
        $value = 'error comment already unliked';
        return '{ "result":"'.$value.'"}';
      }
      $like = $comment->likes()->where('user_id', TEMP_USER_ID)->first();
      $like->delete();
      $value = 'unliked comment';
      return '{ "result":"'.$value.'"}';
    }
  }
  public function likeArticle(Request $request)
  {
    if($request->value == 1) //like article
    {
      $article = \App\Article::where('id', $request->article_id)->first();
      if($article->likes()->where('user_id', TEMP_USER_ID)->first() != null)
      {
        $value = 'error article already liked';
        return '{ "error":"'.$value.'"}';
      }
      $newLike = new Like();
      $newLike->user_id = TEMP_USER_ID;
      $article->likes()->save($newLike);
      $value = 'liked article';
      return '{ "result":"'.$value.'"}';
    }
    else if($request->value == -1) //unlike article
    {
      $article = \App\Article::where('id', $request->article_id)->first();
      if($article->likes()->where('user_id', TEMP_USER_ID)->first() == null)
      {
        $value = $article->likes()->where('user_id', TEMP_USER_ID)->first();
        $value = 'error article already unliked';
        return '{ "error":"'.$value.'"}';
      }
      $like = $article->likes()->where('user_id', TEMP_USER_ID)->first();
      $like->delete();
      $value = 'unliked article';
      return '{ "result":"'.$value.'"}';
    }
  }
  public function viewAllArticleComments(Request $request)
  {
    $comments = \App\Article::where('id', $request->articleID)->first()->comments()->get();
    $data = [];

    foreach ($comments as $key => $comment) {
      $data[$key]['user_id'] = $comment->user_id;
      $data[$key]['username'] = \App\User::where('id', $comment->user_id)->first()->name;
      $data[$key]['id'] = $comment->id;
      $data[$key]['created_at'] = $comment->created_at;
      $data[$key]['updated_at'] = $comment->updated_at;
      $data[$key]['content'] = $comment->content;
      $data[$key]['likes'] = $comment->likes()->count();
      $like = false;
      if($comment->likes()->where('user_id', TEMP_USER_ID)->first() != null)
        $like = true;
      $data[$key]['like'] = $like;
    }
    return json_encode($data);
  }
}
