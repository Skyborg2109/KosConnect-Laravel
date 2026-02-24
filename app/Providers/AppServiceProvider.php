<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for "key too long" error on older MySQL versions
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        // View Composer for Penyewa Views
        \Illuminate\Support\Facades\View::composer(['penyewa.*', 'DashboardPenyewa'], function ($view) {
            try {
                if (session()->has('user') && session('user.role') == 'penyewa') {
                    $penyewaId = session('user.id');
                    $notifications = \App\Models\Notifikasi::where('user_id', $penyewaId)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
                    $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $penyewaId)
                        ->where('is_read', false)
                        ->count();
                    $view->with('notifications', $notifications)
                         ->with('unreadNotificationsCount', $unreadNotificationsCount);
                }
            } catch (\Exception $e) {
                \Log::error('Error in Penyewa View Composer: ' . $e->getMessage());
                $view->with('notifications', collect())
                     ->with('unreadNotificationsCount', 0);
            }
        });

        // View Composer for Pemilik Views
        \Illuminate\Support\Facades\View::composer(['pemilik.*', 'DashboardPemilik'], function ($view) {
            try {
                if (session()->has('user') && session('user.role') == 'pemilik') {
                    $pemilikId = session('user.id');
                    $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
                    $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
                        ->where('is_read', false)
                        ->count();
                    $view->with('notifications', $notifications)
                         ->with('unreadNotificationsCount', $unreadNotificationsCount);
                }
            } catch (\Exception $e) {
                \Log::error('Error in Pemilik View Composer: ' . $e->getMessage());
                $view->with('notifications', collect())
                     ->with('unreadNotificationsCount', 0);
            }
        });

        // View Composer for Admin Views
        \Illuminate\Support\Facades\View::composer(['admin.*', 'DashboardAdmin'], function ($view) {
            try {
                if (session()->has('admin')) {
                    $adminId = session('admin.id');
                    $notifications = \App\Models\Notifikasi::where('user_id', $adminId)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
                    $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $adminId)
                        ->where('is_read', false)
                        ->count();
                    $view->with('notifications', $notifications)
                        ->with('unreadNotificationsCount', $unreadNotificationsCount);
                }
            } catch (\Exception $e) {
                \Log::error('Error in Admin View Composer: ' . $e->getMessage());
                $view->with('notifications', collect())
                    ->with('unreadNotificationsCount', 0);
            }
        });

        // Extend Socialite for Twitter fix
        \Laravel\Socialite\Facades\Socialite::extend('twitter', function ($app) {
            \Log::info('Custom Twitter Provider: Extending twitter driver');
            $config = $app['config']['services.twitter'];
            
            $server = new \App\Services\Socialite\CustomTwitterServer([
                'identifier' => $config['client_id'],
                'secret' => $config['client_secret'],
                'callback_uri' => $config['redirect'],
            ]);
            
            return new \App\Services\Socialite\CustomTwitterProvider(
                $app['request'], $server
            );
        });
    }
}
