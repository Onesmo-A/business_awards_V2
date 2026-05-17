<?php

namespace App\Providers;

use App\Models\NomineeApplication;
use App\Models\Winner;
use App\Models\Vote;
use App\Policies\WinnerPolicy;
use App\Policies\NomineeApplicationPolicy;
use App\Observers\VoteObserver;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
// app/Providers/RouteServiceProvider.php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\RateLimiter;

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
        // Sajili VoteObserver ili iweze kuongeza na kupunguza
        // idadi ya kura kiotomatiki kwenye mshiriki husika.
        Vote::observe(VoteObserver::class);
        Vite::prefetch(concurrency: 3);

        RateLimiter::for('votes', function (Request $request) {
            $fingerprint = (string) $request->input('fingerprint_js', '');
            $browserToken = (string) $request->input('browser_token', '');

            if ($browserToken !== '') {
                return Limit::perMinute(20)->by('browser:' . hash('sha256', $browserToken));
            }

            if ($fingerprint !== '') {
                return Limit::perMinute(20)->by('fingerprint:' . hash('sha256', $fingerprint));
            }

            return Limit::perMinute(20)->by('session:' . $request->session()->getId());
        });

        // Sajili Policies
        Gate::policy(Winner::class, WinnerPolicy::class);

        Gate::policy(NomineeApplication::class, NomineeApplicationPolicy::class);

        // Hii ni kwa ajili ya mazingira ya production (kwenye server halisi)
        // Inahakisha link zote (routes, assets) zinatumia https
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
