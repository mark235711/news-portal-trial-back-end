<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
  protected $fillable = [
      'name', 'teaser', 'published', 'content',
  ];
    public function author()
    {
      return $this->belongsTo('App\User', 'user_id');
    }
    public function likes()
    {
      return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
      return $this->hasMany(Comment::class);
    }
}
