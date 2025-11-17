<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
     
        
        $wishlistItems = Wishlist::with('product') 
            ->where('user_id', auth()->id())
            ->get();
            // dd($wishlistItems);
            return view('wishlist', compact('wishlistItems'));    }
    

            public function addToWishlist($lang,$productId)
            {
                   app()->setLocale($lang);
    $langCode = session('language_code', 'en');
                if (!auth()->check()) {
                    return redirect()->route('login')->with('error', 'Login to add to wishlist');
                }
            
                $exists = Wishlist::where('user_id', auth()->id())
                                  ->where('product_id', $productId)
                                  ->exists();
            
                if (!$exists) {
                    Wishlist::create([
                        'user_id' => auth()->id(),
                        'product_id' => $productId,
                    ]);
                }
            
                return back()->with([
                    'message' => 'Added to wishlist!',
                    'wishlist_product_id' => $productId
                ]);
            }
            

public function removeFromWishlist($lang, $productId)
{
    
    Wishlist::where('user_id', auth()->id())
        ->where('product_id', $productId)
        ->delete();

    return back()->with('message', 'Removed from wishlist!');
}

public function showWishlist()
{
    $wishlist = Wishlist::with('product')->where('user_id', auth()->id())->get();
    return view('wishlist', compact('wishlist'));
}


}
