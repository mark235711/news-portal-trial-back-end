<?php
namespace App\Classes;

class UserManager //all functions are static, use UserManager::getUserWithID sintax to call functions
{
  public static function getUserWithID($userID)
  {
    return \App\User::where('id', $userID)->first();
  }
  public static function addUserPermission($userID, $newPermisson)
  {
    $user = UserManager::getUserWithID($userID);
    if($user == null) //returns false if there isn't a user with the userID
      return false;
    $permissions = unserialize($user->permissions);
    if($permissions[0] == '') //no current permission for user
    {
      $permissions[0] = $newPermisson;
    }
    else //if the user already has permissons
    {
      $isNewPer = true;
      foreach ($permissions as $key => $permission) { //checks to see if the permission is new
        if($permission == $newPermisson)
          $isNewPer = false;
      }
      if($isNewPer) //if the permisson is new it is added to the permisson array
        $permissions[sizeof($permissions)] = $newPermisson;
      else
        return false; //returns false when duplicate permisson is used
    }

    //serializes the permissons and saves it to the database
    $serializedPermissions = serialize($permissions);
    $user->permissions = $serializedPermissions;
    $user->save();

    //returns true to show that the permission and userID are valid, and the permisson is added
    return true;
  }
  public static function checkUserPermission($userID, $permissonToCheck)
  {
    $user = $this->getUserWithID($userID);
    if($user == null) //returns false if there isn't a user with the userID
      return false;
    $permissions = unserialize($user->permissions);

    foreach ($permissions as $key => $permission) { //checks to see if the permission is new
        if($permission == $permissonToCheck)
          return true;
    }
    return false;

  }
}
