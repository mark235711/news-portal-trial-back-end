<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('createArticle', function ($user) {
          return in_array('contributor', unserialize($user->permissions));
        });
        Gate::define('editArticle', function ($user, $article) {
          if($article->user_id == $user->id //if the user created the article
           && $article->published == 0) //and the contributor hasn't asked for the article to be published yet
            return true;
          else if (in_array('editor', unserialize($user->permissions)) //if the user is an editor
          && $article->published != 0) //and if the article is ready to be published by the contrubutor
            return true;
          else
            return false;
        });
        Gate::define('submitArticleForReview', function ($user, $article) {
          if($article->user_id == $user->id //if the user created the article
          && $article->published == 0)
            return true;
            else
              return false;
        });
        Gate::define('deleteArticle', function ($user, $article) {
          if(($article->user_id == $user->id && $article->published == 0) ||  //if the user created the article and not submitted for review
            ((in_array('editor', unserialize($user->permissions))) && $article->published != 0)) //if the user is an editor and the article has been submitted for review or published
              return true;
            else
              return false;
        });

        Gate::define('viewPendingArticles', function ($user) {
          return in_array('editor', unserialize($user->permissions));
        });
        Gate::define('publishArticle', function ($user, $article) {
          return (in_array('editor', unserialize($user->permissions))
          && $article->published == 1);
        });
        Gate::define('pushbackArticle', function ($user, $article) {
          return (in_array('editor', unserialize($user->permissions))
          && $article->published == 1);
        });

    }
}
