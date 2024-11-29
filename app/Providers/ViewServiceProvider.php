<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            // Thêm logic thông báo mà không ảnh hưởng đến phần đã có
            if (Auth::check()) {
                $userId = Auth::id();

                // Lấy thông báo chưa đọc
                $notifications = Notification::where('user_id', $userId)
                    ->whereNull('read_at')
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Lấy tất cả thông báo
                $allNotifications = Notification::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Truyền dữ liệu vào view
                $view->with(compact('notifications', 'allNotifications'));
            } else {
                // Trường hợp không đăng nhập
                $view->with('notifications', []);
                $view->with('allNotifications', []);
            }
        });

    }
}
