<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Classes\UserManager;
use App\Comment;
use App\User;

class TestController extends Controller
{
  //this class is for testing and debuging, remove file if project is used for non testing
    public function index()
    {
      //following lines are used for fake generation of user accounts for testing
      // $this->clearTable('users');
      // $user = new User();
      // $user->name = 'editor 1';
      // $user->email = 'editor1@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // $user = new User();
      // $user->name = 'editor 2';
      // $user->email = 'editor2@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // $user = new User();
      // $user->name = 'contributor 1';
      // $user->email = 'contributor1@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // $user = new User();
      // $user->name = 'contributor 2';
      // $user->email = 'contributor2@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // $user = new User();
      // $user->name = 'contributor 3';
      // $user->email = 'contributor3@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // $user = new User();
      // $user->name = 'contributor 4';
      // $user->email = 'contributor4@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // $user = new User();
      // $user->name = 'contributor 5';
      // $user->email = 'contributor5@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // $user = new User();
      // $user->name = 'contributor 6';
      // $user->email = 'contributor6@fakeemail.com';
      // $user->password = '123456';
      // $user->save();
      // UserManager::addUserPermission(1, 'editor');
      // UserManager::addUserPermission(1, 'contributor');
      // UserManager::addUserPermission(2, 'editor');
      // UserManager::addUserPermission(2, 'contributor');
      // UserManager::addUserPermission(3, 'contributor');
      // UserManager::addUserPermission(4, 'contributor');
      // UserManager::addUserPermission(5, 'contributor');
      // UserManager::addUserPermission(6, 'contributor');
      // UserManager::addUserPermission(7, 'contributor');
      // UserManager::addUserPermission(8, 'contributor');


      // $array = array('1','2','3');
      // $serializedArray = serialize($array);
      // return $serializedArray;

      //return $this->showTableNames();
      //return $this->showTableInfo('users');
      //return $this->showTableInfo('articles');
      //return $this->showTableInfo('likes');
      //return 'test'; //view('home');
      //return 'this is a test to see if I can get Laravel to pass data';
      //return \App\Article::where('id', 4)->first()->author()->get();
      //return \App\User::where('id', 1)->first()->articles()->get();
      //$article = \App\Article::where('id', 4)->first();
      //$newComment = new Comment();
      //$newComment->content = 'this is a test comment';
      //$newComment->user_id = 1;
      //$article->comments()->save($newComment);
      //return \App\Article::where('id', 4)->first()->comments()->get();
      //return $this->showTableInfo('comments');
    }
    public function post(Request $request)
    {
      $test = $request->secondParam;
      //$test = "asdf";
      $value = 'saved';
      return '{ "status":"'.$value.'"}';
    }
    public function get()
    {
      return '{ "answer":"get" }';
    }
    public function showTableNames()
    {
      return DB::select('SHOW TABLES');
    }

    public function showTableInfo($tableName)
    {
      return DB::select('SELECT * FROM '.$tableName);
    }
    public function clearTable($tableName)
    {
      //use following line to clear tables with foreign keys
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table($tableName)->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      return DB::select('SELECT * FROM '.$tableName);
    }
    public function articleChanges()
    {
      return view('Test/testIndex');
    }
}
