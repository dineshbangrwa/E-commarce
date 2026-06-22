<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeCombination;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return $row->getFirstMediaUrl('image')
                        ? '<img src="'.$row->getFirstMediaUrl('image').'" alt="Image" style="max-width: 70px;">'
                        : 'No Image';
                })
                ->addColumn('banner_image', function ($row) {
                    $bannerImages = $row->getMedia('banner_image');
                    $banner_image = '';
                    foreach ($bannerImages as $image) {
                        $banner_image .= '<img src="'.$image->getUrl().'" alt="Banner Image" style="max-width: 70px; margin: 5px;">';
                    }

                    return $banner_image ?: 'No Banner Images';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('product.edit', $row->id);
                    $deleteUrl = route('product.destroy', $row->id);
                    $switch = route('lang.switch.product', $row->id);

                    $btn = '<div class="d-flex gap-2">
                <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                <a href="'.$switch.'" class="btn btn-sm btn-primary">Switch lan.</a>
                <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                    '.csrf_field().method_field('DELETE').'
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>
            </div>';

                    return $btn;
                })
                ->rawColumns(['action', 'image', 'banner_image'])
                ->make(true);
        }

        return view('Admin.Product.index');
    }

    public function create()
    {
        $products = Product::all();
        $categorys = Category::all();
        $product = null;
        $existingAttributes = [];
        $existingCombinations = [];

        return view('Admin.Product.create', compact('products', 'categorys', 'product', 'existingAttributes', 'existingCombinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'special_price' => 'required|numeric|min:0',
            'special_price_from' => 'required|date',
            'special_price_to' => 'required|',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|array',
            'category.*' => 'exists:categories,id',
            'related_product' => 'required|array',
            'related_product.*' => 'exists:products,id',
            'meta_tag' => 'required|string|max:255',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'image' => 'required|image',
            'banner_image' => 'required',
            'banner_image.*' => 'image',
            'attributes' => 'required|array',
            'attributes.*.name' => 'required_with:attributes|string|max:255',
            'attributes.*.values' => 'required_with:attributes|array',
            'attributes.*.values.*' => 'string|max:255',
            'combinations' => 'nullable|array',
            'combinations.*.attribute_values' => [
                'required_with:combinations',
                'json',
                function ($attribute, $value, $fail) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $fail('The '.$attribute.' must be valid JSON.');

                        return;
                    }
                    foreach ($decoded as $item) {
                        if (! isset($item['attribute']) || ! isset($item['value'])) {
                            $fail('Each item in '.$attribute.' must contain "attribute" and "value" keys.');
                        }
                    }
                },
            ],
            'combinations.*.price' => 'required_with:combinations|numeric|min:0',
            'combinations.*.stock' => 'required_with:combinations|integer|min:0',
            'combinations.*.status' => 'required_with:combinations|in:new,updated,existing,deleted',
        ]);

        $insert = [
            'name' => $request->name,
            'status' => $request->status,
            'is_featured' => $request->is_featured ?? 0,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'price' => $request->price,
            'special_price' => $request->special_price,
            'special_price_from' => $request->special_price_from,
            'special_price_to' => $request->special_price_to,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'related_product' => $request->has('related_product') ? implode(',', $request->related_product) : '',
            'url_key' => $request->url_key ?? Str::slug($request->name),
            'meta_tag' => $request->meta_tag,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];

        $product = Product::create($insert);

        if ($request->has('category')) {
            $product->categories()->sync($request->category);
        }

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('image');
        }
        if ($request->hasFile('banner_image')) {
            foreach ($request->file('banner_image') as $bannerImage) {
                $product->addMedia($bannerImage)->toMediaCollection('banner_image');
            }
        }

        // if ($request->has('attributes') || $request->has('combinations')) {
        //     $this->processAttributesAndCombinations($product, $request->input('attributes', []), $request->input('combinations', []));
        // }

        if ($request->has('attributes') || $request->has('combinations')) {
            $this->processAttributesAndCombinations($product, $request->input('attributes', []), $request->input('combinations', []));
        } else {

            AttributeCombination::where('product_id', $product->id)->delete();
            AttributeValue::where('product_id', $product->id)->delete();
            Attribute::where('product_id', $product->id)->delete();
        }

        return redirect()->route('product.index')->with('success', 'Product created successfully!');
    }

    public function edit(string $id)
    {
        $categories = Category::all();
        $products = Product::all();
        $product = Product::with(['categories', 'combinations'])->findOrFail($id);

        $existingAttributes = [];
        $existingCombinations = [];

        $attributes = Attribute::where('product_id', $product->id)->with('values')->get();
        foreach ($attributes as $attribute) {
            $existingAttributes[] = [
                'name' => $attribute->name,
                'values' => $attribute->values->pluck('value')->toArray(),
            ];
        }

        if ($product->combinations->isNotEmpty()) {
            foreach ($product->combinations as $combination) {
                $combinationValues = [];
                $valueIds = $combination->attribute_value_ids ?? [];
                foreach ($valueIds as $valueId) {
                    $attributeValue = AttributeValue::with('attribute')->find($valueId);
                    if ($attributeValue) {
                        $combinationValues[] = [
                            'attribute' => $attributeValue->attribute->name,
                            'value' => $attributeValue->value,
                        ];
                    }
                }
                $existingCombinations[] = [
                    'id' => $combination->id,
                    'attribute_values' => json_encode($combinationValues),
                    'price' => $combination->price,
                    'stock' => $combination->stock,
                ];
            }
        }

        return view('Admin.Product.edit', compact('products', 'product', 'categories', 'existingAttributes', 'existingCombinations'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'status' => 'required|boolean',
        //     'is_featured' => 'nullable|boolean',
        //     'stock' => 'nullable|integer|min:0',
        //     'weight' => 'nullable|numeric|min:0',
        //     'price' => 'required|numeric|min:0',
        //     'special_price' => 'nullable|numeric|min:0',
        //     'special_price_from' => 'nullable|date',
        //     'special_price_to' => 'nullable|date|after_or_equal:special_price_from',
        //     'short_description' => 'nullable|string',
        //     'description' => 'nullable|string',
        //     'category' => 'nullable|array',
        //     'category.*' => 'exists:categories,id',
        //     'related_product' => 'nullable|array',
        //     'related_product.*' => 'exists:products,id',
        //     'meta_tag' => 'nullable|string|max:255',
        //     'meta_title' => 'nullable|string|max:255',
        //     'meta_description' => 'nullable|string',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'banner_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'attributes' => 'nullable|array',
        //     'attributes.*.name' => 'required_with:attributes|string|max:255',
        //     'attributes.*.values' => 'required_with:attributes|array',
        //     'attributes.*.values.*' => 'string|max:255',
        //     'combinations' => 'nullable|array',
        //     'combinations.*.id' => 'nullable|exists:attribute_combinations,id',
        //     'combinations.*.attribute_values' => [
        //         'required_with:combinations',
        //         'json',
        //         function ($attribute, $value, $fail) {
        //             $decoded = json_decode($value, true);
        //             if (json_last_error() !== JSON_ERROR_NONE) {
        //                 $fail('The ' . $attribute . ' must be valid JSON.');
        //                 return;
        //             }
        //             foreach ($decoded as $item) {
        //                 if (!isset($item['attribute']) || !isset($item['value'])) {
        //                     $fail('Each item in ' . $attribute . ' must contain "attribute" and "value" keys.');
        //                 }
        //             }
        //         },
        //     ],
        //     'combinations.*.price' => 'required_with:combinations|numeric|min:0',
        //     'combinations.*.stock' => 'required_with:combinations|integer|min:0',
        //     'combinations.*.status' => 'required_with:combinations|in:new,updated,existing,deleted',
        // ]);

        $insert = [
            'name' => $request->name,
            'status' => $request->status,
            'is_featured' => $request->is_featured ?? 0,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'price' => $request->price,
            'special_price' => $request->special_price,
            'special_price_from' => $request->special_price_from,
            'special_price_to' => $request->special_price_to,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'related_product' => $request->has('related_product') ? implode(',', $request->related_product) : '',
            'url_key' => $request->url_key ?? Str::slug($request->name),
            'meta_tag' => $request->meta_tag,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];

        $product->update($insert);

        if ($request->has('category')) {
            $product->categories()->sync($request->category);
        } else {
            $product->categories()->sync([]);
        }

        if ($request->hasFile('image')) {
            $product->clearMediaCollection('image');
            $product->addMediaFromRequest('image')->toMediaCollection('image');
        }

        if ($request->hasFile('banner_image')) {
            foreach ($request->file('banner_image') as $bannerImage) {
                $product->addMedia($bannerImage)->toMediaCollection('banner_image');
            }
        }

        if ($request->has('delete_image')) {
            foreach ($request->delete_image as $mediaId) {
                $product->media()->where('id', $mediaId)->delete();
            }
        }

        if ($request->has('attributes') || $request->has('combinations')) {
            $this->processAttributesAndCombinations($product, $request->input('attributes', []), $request->input('combinations', []));
        } else {

            AttributeCombination::where('product_id', $product->id)->delete();
            AttributeValue::where('product_id', $product->id)->delete();
            Attribute::where('product_id', $product->id)->delete();
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    private function processAttributesAndCombinations(Product $product, array $attributes, array $combinations)
    {
        $attributeMap = [];
        $existingAttributes = Attribute::where('product_id', $product->id)->get()->keyBy('name');

        foreach ($attributes as $attrData) {
            $attributeName = trim($attrData['name']);
            if (empty($attributeName)) {
                continue;
            }

            $originalName = $attrData['original_name'] ?? null;
            $attribute = null;

            if ($originalName && isset($existingAttributes[$originalName])) {
                $attribute = $existingAttributes[$originalName];

                if ($attribute->name !== $attributeName) {
                    $attribute->update(['name' => $attributeName]);

                    $existingAttributes[$attributeName] = $attribute;
                    unset($existingAttributes[$originalName]);
                }
            } elseif (isset($existingAttributes[$attributeName])) {
                $attribute = $existingAttributes[$attributeName];
            } else {
                $attribute = Attribute::create([
                    'product_id' => $product->id,
                    'name' => $attributeName,
                ]);
                $existingAttributes[$attributeName] = $attribute;
            }

            $values = array_filter(array_map('trim', $attrData['values']), fn ($v) => $v !== '');
            $attributeValueIds = [];

            foreach ($values as $value) {
                $attributeValue = AttributeValue::firstOrCreate([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'value' => $value,
                ]);
                $attributeValueIds[] = $attributeValue->id;
                $attributeMap[$attributeName][$value] = $attributeValue->id;
            }

            AttributeValue::where('attribute_id', $attribute->id)
                ->whereNotIn('id', $attributeValueIds)
                ->delete();
        }

        $this->processCombinations($product, $combinations, $attributeMap);

        $this->cleanupOrphanedAttributes($product);
    }

    private function processCombinations(Product $product, array $combinations, array $attributeMap)
    {

        if (empty($combinations)) {
            AttributeCombination::where('product_id', $product->id)->delete();

            return;
        }

        // Get all combo IDs present in the request (except new)
        $requestedIds = [];
        foreach ($combinations as $comboData) {
            if (! empty($comboData['id']) && isset($comboData['status']) && $comboData['status'] !== 'new') {
                $requestedIds[] = $comboData['id'];
            }
        }

        // Get all existing combination IDs for this product
        $existingIds = AttributeCombination::where('product_id', $product->id)->pluck('id')->toArray();

        // Calculate the IDs NOT present in the form (removed/deleted)
        $toDelete = array_diff($existingIds, $requestedIds);

        // Delete all not-present IDs
        if (! empty($toDelete)) {
            AttributeCombination::whereIn('id', $toDelete)->delete();
        }

        // Process input combinations as before
        foreach ($combinations as $comboData) {
            $status = $comboData['status'] ?? 'new';

            if ($status === 'deleted' && isset($comboData['id'])) {
                AttributeCombination::where('id', $comboData['id'])->delete();

                continue;
            }

            $attrValues = json_decode($comboData['attribute_values'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                continue;
            }

            $valueIds = [];
            foreach ($attrValues as $av) {
                $attrName = trim($av['attribute']);
                $value = trim($av['value']);
                if (isset($attributeMap[$attrName][$value])) {
                    $valueIds[] = $attributeMap[$attrName][$value];
                }
            }
            if (empty($valueIds)) {
                continue;
            }

            sort($valueIds);

            $data = [
                'product_id' => $product->id,
                'attribute_value_ids' => $valueIds,
                'price' => $comboData['price'],
                'stock' => $comboData['stock'],
            ];

            if (isset($comboData['id']) && ($status === 'existing' || $status === 'updated')) {
                AttributeCombination::where('id', $comboData['id'])->update($data);
            } elseif ($status === 'new') {
                AttributeCombination::create($data);
            }
        }
    }

    private function cleanupOrphanedAttributes(Product $product)
    {

        $usedValueIds = AttributeCombination::where('product_id', $product->id)
            ->pluck('attribute_value_ids')
            ->flatMap(fn ($ids) => is_array($ids) ? $ids : [])
            ->unique()
            ->filter();

        AttributeValue::where('product_id', $product->id)
            ->whereNotIn('id', $usedValueIds)
            ->delete();

        $usedAttributeIds = AttributeValue::where('product_id', $product->id)
            ->pluck('attribute_id')
            ->unique();

        Attribute::where('product_id', $product->id)
            ->whereNotIn('id', $usedAttributeIds)
            ->delete();
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->clearMediaCollection('image');
        $product->clearMediaCollection('banner_image');
        $product->combinations()->delete();
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
