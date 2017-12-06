<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = [
    'content',
  ];

    public function likes()
    {
      return $this->morphMany('App\Like', 'likeable');
    }
    public function article()
    {
      return $this->hasOne(Article::class);
    }
    public function user()
    {
      return $this->hasOne(User::class);
    }
}
