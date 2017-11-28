<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Classes\UserManager;

class TestController extends Controller
{
  //this class is for testing and debuging, remove file if project is used for non testing
    public function index()
    {

      //UserManager::addUserPermission(2, 'contributor');
      //UserManager::addUserPermission(2, 'editor');

      // $array = array('1','2','3');
      // $serializedArray = serialize($array);
      // return $serializedArray;

      //return $this->showTableNames();
      //return $this->showTableInfo('users');
      return $this->showTableInfo('articles');
      //return $this->clearTable('articles');
      //return 'test'; //view('home');
      //return 'this is a test to see if I can get Laravel to pass data';
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
      DB::table($tableName)->truncate();
      return DB::select('SELECT * FROM '.$tableName);
    }
    public function articleChanges()
    {
      return view('Test/testIndex');
    }
}
