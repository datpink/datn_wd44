<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Chia sẻ biến bài viết mới nhất với view sidebar
        View::composer('client.layouts.sidebar_post', function ($view) {
            $latestPosts = Post::join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.*', 'users.name as author_name')
                ->orderBy('posts.created_at', 'desc')
                ->limit(5)
                ->get();

            $view->with('latestPosts', $latestPosts);
        });
    }
}
