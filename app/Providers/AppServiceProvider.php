<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Quote;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        $locale = session('language_code', config('app.locale'));
        app()->setLocale($locale);

        Model::automaticallyEagerLoadRelationships();
        Paginator::useBootstrapFive();
        if (! session()->has('currency_code')) {
            $default = Currency::where('is_default', 1)->first();

            if ($default) {
                session([
                    'currency_code' => $default->code,
                    'currency_symbol' => $default->symbol,
                    'currency_rate' => 1,
                ]);
            }
        }

        View::composer('*', function ($view) {
            // --- Cart Count Logic ---
            $quoteId = session('quote_id');
            // dd($quoteId);
            if ($quoteId) {
                $quote = Quote::with('quoteItems')->find($quoteId);
                $cartCount = $quote ? $quote->quoteItems->count() : 0;
            } else {
                $cartCount = 0;
            }

            // --- Wishlist Count Logic ---
            $wishlistCount = 0;
            if (Auth::check()) {
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            }

            $view->with([
                'cartCount' => $cartCount,
                'wishlistCount' => $wishlistCount,
            ]);

        });
        View::composer('*', function ($view) {
            $users = User::where('is_admin', 0)
                ->latest()
                ->take(5)
                ->get();
            $view->with('users', $users);
        });
    }
}
