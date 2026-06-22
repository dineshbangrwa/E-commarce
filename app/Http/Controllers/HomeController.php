<?php

namespace App\Http\Controllers;

use App\Models\AttributeCombination;
use App\Models\AttributeValue;
use App\Models\Block;
use App\Models\Category;
use App\Models\CatLanguage;
use App\Models\Enquiry;
use App\Models\Order;
use App\Models\Page;
use App\Models\PageLanguage;
use App\Models\Product;
use App\Models\ProLanguage;
use App\Models\Slider;
use App\Models\SlidLanguage;
use App\Models\Translation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $blocks = Block::all();
        $pages = Page::all();
        $langCode = session('language_code', 'en');

        $blocks->transform(function ($block) use ($langCode) {
            $translation = Translation::where('block_id', $block->id)->first();
            if ($translation && isset($translation->translated_data[$langCode])) {
                $data = $translation->translated_data[$langCode];
                $block->name = $data['name'] ?? $block->name;
                $block->description = $data['description'] ?? $block->description;
            }

            return $block;
        });

        $sliders->transform(function ($slider) use ($langCode) {
            $translation = SlidLanguage::where('slider_id', $slider->id)->first();
            if ($translation && isset($translation->translated_data[$langCode])) {
                $data = $translation->translated_data[$langCode];
                $slider->title = $data['title'] ?? $slider->title;
                $slider->description = $data['description'] ?? $slider->description;
            }

            return $slider;
        });

        return view('index', compact('sliders', 'blocks', 'pages', 'langCode'));
    }

    public function page($lang, $url_key)
    {
        app()->setLocale($lang);
        $langCode = session('language_code', $lang);

        $page = Page::where('url_key', $url_key)->firstOrFail();

        $translation = PageLanguage::where('page_id', $page->id)->first();
        if ($translation && isset($translation->translated_data[$langCode])) {
            $data = $translation->translated_data[$langCode];
            $page->name = $data['name'] ?? $page->name;
            $page->description = $data['description'] ?? $page->description;
            $page->meta_description = $data['meta_description'] ?? $page->meta_description;
            $page->meta_title = $data['meta_title'] ?? $page->meta_title;
        }

        return view('about', compact('page'));
    }

    public function product($lang, $url_key)
    {
        app()->setLocale($lang);
        $langCode = session('language_code', $lang);

        $product = Product::where('url_key', $url_key)->with('reviews')->first();

        if (! $product) {
            abort(404);
        }

        $translation = ProLanguage::where('product_id', $product->id)->first();

        if ($translation && isset($translation->translated_data[$langCode])) {
            $data = $translation->translated_data[$langCode];
            $product->name = $data['name'] ?? $product->name;
            $product->description = $data['description'] ?? $product->description;
            $product->short_description = $data['short_description'] ?? $product->short_description;
        }

        $approvedReviews = $product->reviews()->where('approved', true)->latest()->get();

        $relatedProductIds = explode(',', $product->related_product ?? '');
        $relatedProducts = Product::whereIn('id', $relatedProductIds)->get();

        $attributeCombinations = AttributeCombination::where('product_id', $product->id)->get();

        return view('shop-detail', compact(
            'product',
            'relatedProducts',
            'attributeCombinations',
            'approvedReviews'
        ));
    }

    public function category(Request $request, $lang, $url_key)
    {
        app()->setLocale($lang);
        $langCode = session('language_code', 'en');

        $category = Category::where('url_key', $url_key)->firstOrFail();

        $translation = CatLanguage::where('category_id', $category->id)->first();

        if ($translation && isset($translation->translated_data[$langCode]['name'])) {
            $category->name = $translation->translated_data[$langCode]['name'];
        }
        $query = $category->products()->with('attributeValues.attribute');

        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $query->whereBetween('price', [(float) $min, (float) $max]);
        }

        if ($request->filled('size')) {
            $query->whereHas('attributeValues', function ($q) use ($request) {
                $q->where('value', $request->size)->whereHas('attribute', function ($a) {
                    $a->where('name', 'Size');
                });
            });
        }

        if ($request->filled('color')) {
            $query->whereHas('attributeValues', function ($q) use ($request) {
                $q->where('value', $request->color)->whereHas('attribute', function ($a) {
                    $a->where('name', 'Color');
                });
            });
        }

        $products = $query->paginate(12)->appends($request->query());
        $products->getCollection()->transform(function ($product) use ($langCode) {
            $translation = ProLanguage::where('product_id', $product->id)->first();

            if ($translation && isset($translation->translated_data[$langCode]['name'])) {
                $product->translated_name = $translation->translated_data[$langCode]['name'];
            } else {
                $product->translated_name = $product->name;
            }

            return $product;
        });
        $productIds = $products->pluck('id')->toArray();
        $sizes = AttributeValue::whereIn('product_id', $productIds)
            ->whereHas('attribute', function ($q) {
                $q->where('name', 'Size');
            })
            ->pluck('value')
            ->unique()
            ->values();

        $colors = AttributeValue::whereIn('product_id', $productIds)
            ->whereHas('attribute', function ($q) {
                $q->where('name', 'Color');
            })
            ->pluck('value')
            ->unique()
            ->values();

        return view('shop', compact('products', 'category', 'sizes', 'colors'));
    }

    // =================Contact Detail======================

    public function contact(Request $request)
    {
        return view('contact');
    }

    public function store(Request $request)
    {

        // dd($request->all());
        //    $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'phone' => 'required',
        //     'description' => 'required',
        // ]);

        $insert = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];
        Enquiry::create($insert);

        return redirect()->route('index')->with('success', 'Message Sent Successfully!');
    }

    public function order()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);

        return view('order', compact('orders'));
    }

    public function show($lang, Order $order)
    {
        // Optional: Check if the user is the owner

        app()->setLocale($lang);
        $langCode = session('language_code', 'en');
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('order_items.product'); // assuming relation exists

        return view('ordershow', compact('order'));
    }
}
