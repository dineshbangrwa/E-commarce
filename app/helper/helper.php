<?php

use App\Models\Category;
use App\Models\CatLanguage;
use App\Models\Page;
use App\Models\PageLanguage;
use App\Models\Product;
use App\Models\ProLanguage;
use App\Models\Quote;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;

// if (!function_exists('')) {
//     function product()
//     {
//         $product = Product::where('status',1)->get();
//         return $product;

//     }
// }

if (! function_exists('product')) {
    function product()
    {
        $langCode = session('language_code', config('app.locale'));

        $products = Product::where('status', 1)
            ->where('is_featured', 1)
            ->get();

        foreach ($products as $product) {
            $translation = ProLanguage::where('product_id', $product->id)->first();
            if ($translation && isset($translation->translated_data[$langCode]['name'])) {
                $product->translated_name = $translation->translated_data[$langCode]['name'];
            } else {
                $product->translated_name = $product->name;
            }
        }

        return $products;
    }
}

if (! function_exists('')) {
    function quote()
    {
        $quote = null;

        if (Auth::check()) {
            $quote = Quote::where('user_id', Auth::id())->with('quoteItems')->first();
        } else {
            $cartId = session('cart_id');
            $quote = Quote::where('cart_id', $cartId)->with('quoteItems')->first();
        }
        if (Auth::check()) {
            $quote = Quote::where('user_id', Auth::id())->with('quoteItems')->first();
        } else {
            $cartId = session('cart_id');
            $quote = Quote::where('cart_id', $cartId)->with('quoteItems')->first();
        }

        return $quote;
    }
}

if (! function_exists('')) {
    function slider()
    {
        $slider = Slider::all();

        return $slider;
    }
}
if (! function_exists('category')) {
    function category()
    {
        $langCode = session('language_code', config('app.locale'));

        $categories = Category::where('status', 0)
            ->with('subcategories')
            ->get();

        foreach ($categories as $category) {
            $translation = CatLanguage::where('category_id', $category->id)->first();
            if ($translation && isset($translation->translated_data[$langCode]['name'])) {
                $category->name = $translation->translated_data[$langCode]['name'];
            }

            // Subcategories के लिए भी translation
            foreach ($category->subcategories as $sub) {
                $subTranslation = CatLanguage::where('category_id', $sub->id)->first();
                if ($subTranslation && isset($subTranslation->translated_data[$langCode]['name'])) {
                    $sub->name = $subTranslation->translated_data[$langCode]['name'];
                }
            }
        }

        return $categories;
    }
}

if (! function_exists('page')) {
    function page()
    {
        $langCode = session('language_code', config('app.locale'));

        $pages = Page::where('status', 1)->get();

        foreach ($pages as $page) {
            $translation = PageLanguage::where('page_id', $page->id)->first();

            if ($translation && isset($translation->translated_data[$langCode]['name'])) {

                $page->name = $translation->translated_data[$langCode]['name'];
            }
        }

        return $pages;
    }
}

if (! function_exists('category1')) {
    function category1()
    {
        $langCode = session('language_code', config('app.locale'));

        $categories = Category::where('parent_category', 0)->get();

        foreach ($categories as $category) {
            $translation = CatLanguage::where('category_id', $category->id)->first();

            if ($translation && isset($translation->translated_data[$langCode]['name'])) {
                $category->name = $translation->translated_data[$langCode]['name'];
                $category->description = $translation->translated_data[$langCode]['description'] ?? $category->description;
                $category->short_description = $translation->translated_data[$langCode]['short_description'] ?? $category->short_description;
                $category->meta_description = $translation->translated_data[$langCode]['meta_description'] ?? $category->meta_description;
            }
        }

        return $categories;
    }
}

if (! function_exists('subcategory')) {
    function subcategory($id)
    {
        $langCode = session('language_code', config('app.locale'));

        $categories = Category::where('parent_category', $id)->get();

        foreach ($categories as $category) {
            $translation = CatLanguage::where('category_id', $category->id)->first();

            if ($translation && isset($translation->translated_data[$langCode]['name'])) {
                $category->name = $translation->translated_data[$langCode]['name'];
                $category->description = $translation->translated_data[$langCode]['description'] ?? $category->description;
                $category->short_description = $translation->translated_data[$langCode]['short_description'] ?? $category->short_description;
                $category->meta_description = $translation->translated_data[$langCode]['meta_description'] ?? $category->meta_description;
            }
        }

        return $categories;
    }
}

//  function product1() {
//     return Product::where('status', 1)->get();
// }

function product1()
{
    $langCode = session('language_code', config('app.locale'));

    $products = Product::where('status', 0)
        ->where('is_featured', 1)
        ->get();

    foreach ($products as $product) {
        $translation = ProLanguage::where('product_id', $product->id)->first();
        if ($translation && isset($translation->translated_data[$langCode]['name'])) {
            $product->translated_name = $translation->translated_data[$langCode]['name'];
        } else {
            $product->translated_name = $product->name;
        }
    }

    return $products;
}

if (! function_exists('getProductPrice')) {
    function getProductPrice(Product $product)
    {
        return $product->special_price ?? $product->price;
    }
}
