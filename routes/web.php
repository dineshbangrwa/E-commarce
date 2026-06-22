<?php

use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CurrencyExchangeRateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\FCurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Language\BlockTranslationController;
use App\Http\Controllers\Language\LanCatController;
use App\Http\Controllers\Language\LanguageController;
use App\Http\Controllers\Language\LanPageController;
use App\Http\Controllers\Language\LanProductController;
use App\Http\Controllers\Language\LanSliderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\WishlistController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

// Route::get('wellcome',function() {
//     return view('welcome');
// });

Route::get('/', function () {
    $lang = session('language_code', config('app.locale', 'en'));

    return redirect()->route('index', ['lang' => $lang]);
});
Route::get('/', [HomeController::class, 'index'])->name('index');

Route::group(['prefix' => '{lang}', 'where' => ['lang' => '[a-zA-Z]{2}'], 'middleware' => 'setLocale'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('lang.index');
    Route::get('page-{url_key}', [HomeController::class, 'page'])->name('page');
    Route::get('/category-{url_key}', [HomeController::class, 'category'])->name('category');
    Route::get('/product/{url_key}', [HomeController::class, 'product'])->name('product.detail');
    Route::get('product-{url_key}', [HomeController::class, 'product'])->name('product');
    Route::get('contact', [HomeController::class, 'contact'])->name('contact');
    Route::post('contact', [HomeController::class, 'store'])->name('contact.store');

    Route::middleware('auth')->group(function () {
        Route::get('/my-orders', [HomeController::class, 'order'])->name('orders.index');
        Route::get('/my-orders/{order}', [HomeController::class, 'show'])->name('orders.show');
        Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.index');
        Route::get('/wishlist/add/{id}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
        Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'removeFromWishlist'])
    ->name('wishlist.remove');
    });

    Route::get('profile', [CustomLoginController::class, 'profile'])->name('profile');

    Route::get('search', [SearchController::class, 'search'])->name('search');

    Route::put('/profile/update', [CustomLoginController::class, 'update'])->name('profile.update');
    Route::post('/profile/image-upload', [CustomLoginController::class, 'uploadImage'])->name('profile.image.upload');

    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::post('cart.store', [CartController::class, 'store'])->name('cart.store');
    Route::post('coupon', [CartController::class, 'coupon'])->name('coupon_dis');
    Route::put('/cart/update-ajax/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::get('/buy/{id}', [BuyNowController::class, 'checkout'])->name('buy');
    Route::post('/buy/apply-coupon', [BuyNowController::class, 'applyCoupon'])->name('apply.coupon');
});
Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('buycheckout', [BuyController::class, 'buystore'])->name('checkout.buy');

Route::controller(StripeController::class)->group(function () {
    Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
    Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');
});

Route::get('login', [CustomLoginController::class, 'index'])->name('login');

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');

Route::get('/auth/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::where('email', $googleUser->email)->first();
    if (! $user) {
        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => Hash::make(Str::random(16)),
            'gender' => 1,
            'is_admin' => 0,
        ]);
        if ($googleUser->avatar) {
            $user->addMediaFromUrl($googleUser->avatar)->toMediaCollection('image');
        }
    }
    Auth::login($user);

    return redirect()->route('index')->with('message', 'Login successful via Google');
});

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('remove');

Route::post('login', [CustomLoginController::class, 'store'])->name('custom.post');
Route::get('register', [CustomLoginController::class, 'register'])->name('register');
Route::post('register', [CustomLoginController::class, 'registerStore'])->name('register.store');
Route::get('logout', [CustomLoginController::class, 'logout'])->name('logout');

Route::controller(BuyNowController::class)->group(function () {
    Route::post('buystripe', [BuyNowController::class, 'stripePost'])->name('stripe.buy');
    Route::get('/buy/checkout/success', [BuyNowController::class, 'buysuccess'])->name('buy.success');
    Route::get('buy/checkout/cancel', [BuyNowController::class, 'buycancel'])->name('buy.cancel');
});

// ADMIN ROUTES =========
Route::get('admin_login', [LoginController::class, 'login'])->name('admin.login');
Route::post('store', [LoginController::class, 'store'])->name('login.store');
Route::post('adminregister', [LoginController::class, 'adminregister'])->name('adminregister.store');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'CustomCheck']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('block', BlockController::class);
    Route::resource('slider', SliderController::class);
    Route::resource('page', PageController::class);
    Route::resource('enquiry', EnquiryController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('coupon', CouponController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);
    Route::resource('currency', CurrencyController::class);
    Route::resource('exchange_rates', CurrencyExchangeRateController::class);
    Route::resource('reviews', ReviewController::class);
    Route::get('admin_logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::post('/currency/change', [FCurrencyController::class, 'change'])->name('currency.change');

Route::get('sitemap.xml', function () {
    return response()->file(public_path('sitemap.xml'));
});

Route::post('/language/change', [LanguageController::class, 'change'])->name('language.change');

// Block Translation
Route::get('/lang/block/{id}', [BlockTranslationController::class, 'index'])->name('lang.switch.block');
Route::get('/block/translation/{id}', [BlockTranslationController::class, 'getTranslation']);
Route::post('/block/translation/{blockId}', [BlockTranslationController::class, 'storeTranslation']);

// Product Translation
Route::get('/lang/product/{id}', [LanProductController::class, 'index'])->name('lang.switch.product');
Route::get('/product/translation/{id}', [LanProductController::class, 'getTranslation']);
Route::post('/product/translation/{productId}', [LanProductController::class, 'storeTranslation']);

// ====slider lang=============
Route::get('/lang/slider/{id}', [LanSliderController::class, 'index'])->name('lang.switch.slider');
Route::get('/slider/translation/{id}', [LanSliderController::class, 'getTranslation']);
Route::post('/slider/translation/{sliderId}', [LanSliderController::class, 'storeTranslation']);

// =====Page lang=============
Route::get('/lang/page/{id}', [LanPageController::class, 'index'])->name('lang.switch.page');
Route::get('/page/translation/{id}', [LanPageController::class, 'getTranslation']);
Route::post('/page/translation/{pageId}', [LanPageController::class, 'storeTranslation']);

// ============Category========
Route::get('/lang/category/{id}', [LanCatController::class, 'index'])->name('lang.switch.category');
Route::get('/category/translation/{id}', [LanCatController::class, 'getTranslation']);
Route::post('/category/translation/{categoryId}', [LanCatController::class, 'storeTranslation']);

// Route::get('paypal', [PayPalController::class, 'index'])->name('paypal');
// Route::get('paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
// Route::get('paypal/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
// Route::get('paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment/cancel');
