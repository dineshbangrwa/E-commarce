@extends('admin/layout')
@section('title', 'Edit - Product')

@section('content')
    <style>
        .error {
            color: red;
        }

        .attribute-section {
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
        }

        .attribute-value-input {
            flex-grow: 1;
            margin-right: 5px;
        }

        .attribute-values-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .value-container {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
    </style>

    <style>
        .two-columns {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .two-columns>.form-group {
            flex: 1 1 45%;
            min-width: 200px;
        }
    </style>

    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="two-columns">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="" disabled>Select status</option>
                    <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control" name="image" id="image">
                @if ($product->getFirstMediaUrl('image'))
                    <img src="{{ $product->getFirstMediaUrl('image') }}" loading="lazy" alt="Product Image"
                        style="max-width: 60px; margin-top: 10px;">
                @endif
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="banner_image">Banner Images</label>
                <input type="file" class="form-control" name="banner_image[]" id="banner_image" multiple>
                @if ($product->getMedia('banner_image')->count())
                    <div style="margin-top: 10px;">
                        @foreach ($product->getMedia('banner_image') as $banner)
                            <div style="display: inline-block; margin-right: 10px;">
                                <img src="{{ $banner->getUrl() }}" loading="lazy" alt="Banner Image"
                                    style="max-width: 60px;margin-top: 15px;">
                                <input type="checkbox" name="delete_image[]" value="{{ $banner->id }}"> Delete
                            </div>
                        @endforeach
                    </div>
                @endif
                @error('banner_image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_featured">Is Featured</label>
                <select class="form-control" name="is_featured" id="is_featured">
                    <option value="">Select</option>
                    <option value="1" {{ old('is_featured', $product->is_featured) == 1 ? 'selected' : '' }}>Yes
                    </option>
                    <option value="0" {{ old('is_featured', $product->is_featured) == 0 ? 'selected' : '' }}>No
                    </option>
                </select>
                @error('is_featured')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" name="stock" id="stock"
                    value="{{ old('stock', $product->stock) }}" placeholder="Enter stock">
                @error('stock')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="number" class="form-control" name="weight" id="weight"
                    value="{{ old('weight', $product->weight) }}" placeholder="Enter weight">
                @error('weight')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" id="price"
                    value="{{ old('price', $product->price) }}" placeholder="Enter price">
                @error('price')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="special_price">Special Price</label>
                <input type="number" class="form-control" name="special_price" id="special_price"
                    value="{{ old('special_price', $product->special_price) }}" placeholder="Enter special price">
                @error('special_price')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="special_price_from">Special Price From</label>
                <input type="date" class="form-control" name="special_price_from" id="special_price_from"
                    value="{{ old('special_price_from', $product->special_price_from ? \Carbon\Carbon::parse($product->special_price_from)->format('Y-m-d') : '') }}">
                @error('special_price_from')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="special_price_to">Special Price To</label>
                <input type="date" class="form-control" name="special_price_to" id="special_price_to"
                    value="{{ old('special_price_to', $product->special_price_to ? \Carbon\Carbon::parse($product->special_price_to)->format('Y-m-d') : '') }}">
                @error('special_price_to')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-select form-control" id="category" name="category[]" multiple>
                <option value="" disabled>Select Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $product->categories->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <input class="form-control" name="short_description" id="short_description" rows="3"
                value="{{ old('short_description', $product->short_description) }}"
                placeholder="Enter short description">
            @error('short_description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="related_product">Related Product</label>
            <select class="form-select form-control" id="related_product" name="related_product[]" multiple>
                <option value="" disabled>Select related products</option>
                @foreach ($products as $relatedProduct)
                    <option value="{{ $relatedProduct->id }}"
                        {{ in_array($relatedProduct->id, old('related_product', explode(',', $product->related_product) ?? []))
                            ? 'selected'
                            : '' }}>
                        {{ $relatedProduct->name }}
                    </option>
                @endforeach
            </select>
            @error('related_product')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="meta_tag">Meta Tag</label>
            <input type="text" class="form-control" name="meta_tag" id="meta_tag"
                value="{{ old('meta_tag', $product->meta_tag) }}" placeholder="Enter meta tag">
            @error('meta_tag')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="meta_title">Meta Title</label>
            <input type="text" class="form-control" name="meta_title" id="meta_title"
                value="{{ old('meta_title', $product->meta_title) }}" placeholder="Enter meta title">
            @error('meta_title')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="meta_description">Meta Description</label>
            <textarea class="form-control" name="meta_description" id="meta_description" rows="3"
                placeholder="Enter meta description">{{ old('meta_description', $product->meta_description) }}</textarea>
            @error('meta_description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div id="attribute-section" class="attribute-section">
            <h4>Product Attributes</h4>
            <div id="attributes-container">
                @foreach ($existingAttributes as $index => $attribute)
                    <div class="form-group border p-3 mb-3" data-index="{{ $index }}">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <input type="hidden" name="attributes[{{ $index }}][original_name]"
                                    value="{{ $attribute['name'] }}">
                                <input type="text" name="attributes[{{ $index }}][name]"
                                    value="{{ $attribute['name'] }}" class="form-control attribute-name mr-2" required>
                                <button type="button" class="btn btn-sm btn-danger" id="removeAttribute">X</button>
                            </div>
                            <div class="attribute-values-wrapper" id="values-wrapper-{{ $index }}">
                                @foreach ($attribute['values'] as $value)
                                    <div class="value-container">
                                        <input type="text" name="attributes[{{ $index }}][values][]"
                                            value="{{ $value }}" class="form-control attribute-value-input"
                                            required>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="removeValue(this)">x</button>
                                    </div>
                                @endforeach
                                <div class="value-container">
                                    <input type="text" class="form-control attribute-value-input"
                                        placeholder="Add new value">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="addValue({{ $index }})">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-primary" onclick="addNewAttribute()">Add New Attribute</button>
        </div>
        @error('attributes')
            <div class="error">{{ $message }}</div>
        @enderror

        <hr>
        <div id="combinations-section" class="attribute-section">
            <h4>Generated Combinations</h4>
            <table class="table table-bordered" id="combinations-table">
                <thead>
                    <tr>
                        <th>Combination</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="combinations-table-body">
                    @foreach ($existingCombinations as $index => $combination)
                        @php
                            $attrValues = json_decode($combination['attribute_values'], true);
                            if (json_last_error() !== JSON_ERROR_NONE) {
                                $attrValues = [];
                            }
                        @endphp
                        <tr>
                            <td>
                                <input type="hidden" name="combinations[{{ $index }}][attribute_values]"
                                    value='{{ $combination['attribute_values'] }}'>
                                <input type="hidden" name="combinations[{{ $index }}][status]" value="existing">
                                <input type="hidden" name="combinations[{{ $index }}][id]"
                                    value="{{ $combination['id'] }}">
                                @foreach ($attrValues as $item)
                                    {{ $item['attribute'] }}: {{ $item['value'] }}@if (!$loop->last)
                                        /
                                    @endif
                                @endforeach
                            </td>
                            <td><input type="number" step="0.01" name="combinations[{{ $index }}][price]"
                                    value="{{ $combination['price'] }}" class="form-control" required></td>
                            <td><input type="number" name="combinations[{{ $index }}][stock]"
                                    value="{{ $combination['stock'] }}" class="form-control" required></td>
                            <td><button type="button" class="btn btn-sm btn-danger"
                                    onclick="removeCombination(this)">Remove</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @error('combinations')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="card-action">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('meta_description');
    </script>
@endsection

@section('script')
    <script>
        let attributeIndex = {{ count($existingAttributes) }};
        let attributes = @json($existingAttributes);
        attributes = attributes.map((attr, index) => ({
            name: attr.name || '',
            values: Array.isArray(attr.values) ? [...new Set(attr.values.filter(val => val.trim() !== ''))] :
            [],
            originalIndex: index
        }));
        const oldCombinations = @json($existingCombinations);

        function addNewAttribute() {
            addAttribute('', [], false, true);
            generateCombinations();
        }

        function addAttribute(name = '', values = [], skipGenerate = false, isNewAttribute = false) {
            if (name && !isNewAttribute && attributes.some(attr => attr.name.toLowerCase() === name.toLowerCase() && attr
                    .originalIndex !== attributeIndex)) {
                return;
            }


            const container = document.getElementById('attributes-container');
            if (!container) return;

            const div = document.createElement('div');
            div.classList.add('form-group', 'border', 'p-3', 'mb-3');
            div.dataset.index = attributeIndex;

            values = [...new Set(values.filter(val => val.trim() !== ''))];

            div.innerHTML = `
            <div>
                <div class="d-flex align-items-center mb-2">
                    <input type="text" name="attributes[${attributeIndex}][name]" value="${name}" 
                           placeholder="Attribute name (e.g., Color)" 
                           class="form-control attribute-name mr-2" required 
                           oninput="updateAttributeName(${attributeIndex}, this.value)">
                    <button type="button" class="btn btn-sm btn-danger" id="removeAttribute">X</button>
                </div>
                <div class="attribute-values-wrapper" id="values-wrapper-${attributeIndex}">
                    ${values.map(val => `
                            <div class="value-container">
                                <input type="text" name="attributes[${attributeIndex}][values][]" value="${val}" 
                                       class="form-control attribute-value-input" required 
                                       placeholder="Value (e.g., Red)" 
                                       oninput="updateValues(${attributeIndex})">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeValue(this)">x</button>
                            </div>
                        `).join('')}
                    <div class="value-container">
                        <input type="text" class="form-control attribute-value-input" 
                               placeholder="Add new value" 
                               onkeydown="handleValueEnter(event, ${attributeIndex})">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addValue(${attributeIndex})">+</button>
                    </div>
                </div>
            </div>
        `;

            container.appendChild(div);
            attributes.push({
                name,
                values,
                originalIndex: attributeIndex
            });
            attributeIndex++;
            let removeButtons = document.querySelectorAll("#removeAttribute");
            removeButtons.forEach(button => {
                button.addEventListener('click', () => removeAttribute(button));
            });
            if (!skipGenerate) {
                generateCombinations();
            }
        }

        function addValue(index) {
            const wrapper = document.getElementById(`values-wrapper-${index}`);
            const lastInput = wrapper.querySelector('.value-container:last-child input[type="text"]');
            const value = lastInput.value.trim();

            if (!value) return;

            const valueContainer = document.createElement('div');
            valueContainer.className = 'value-container';
            valueContainer.innerHTML = `
            <input type="text" name="attributes[${index}][values][]" value="${value}" 
                   class="form-control attribute-value-input" required 
                   placeholder="Value (e.g., Red)" 
                   oninput="updateValues(${index})">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeValue(this)">x</button>
        `;
            wrapper.insertBefore(valueContainer, wrapper.lastElementChild);
            //  wrapper.insertBefore(valueContainer, wrapper.firstChild);

            lastInput.value = '';
            updateValues(index);
        }

        function updateAttributeName(index, name) {
            if (name && attributes.some((attr, i) => i !== index && attr.name.toLowerCase() === name.toLowerCase())) {
                alert('This attribute name already exists!');
                document.querySelector(`.form-group[data-index="${index}"] .attribute-name`).value = attributes[index].name;
                return;
            }
            attributes[index].name = name.trim();
            generateCombinations();
        }

        function updateValues(index) {
            const wrapper = document.getElementById(`values-wrapper-${index}`);
            if (!wrapper) return;

            const valueInputs = wrapper.querySelectorAll('input[name^="attributes"]');
            const values = Array.from(valueInputs)
                .map(input => input.value.trim())
                .filter(val => val !== '');

            attributes[index].values = [...new Set(values)];
            generateCombinations();
        }

        let removeButtons = document.querySelectorAll("#removeAttribute");
        removeButtons.forEach(button => {
            button.addEventListener('click', () => removeAttribute(button));
        });

        // function removeAttribute(button) {
        //     const div = button.closest('.form-group');
        //     const index = parseInt(div.dataset.index);
        //     div.remove();
        //     attributes = attributes.filter(attr => attr.originalIndex !== index);
        //     generateCombinations();
        // }

        function removeAttribute(button) {
            const div = button.closest('.form-group');
            const index = parseInt(div.dataset.index);
            div.remove();
            attributes = attributes.filter(attr => attr.originalIndex !== index);
            if (attributes.length === 0) {

                attributeIndex = 0;
                attributes = [];
            }
            generateCombinations();
        }


        function removeValue(button) {
            const index = parseInt(button.closest('.form-group').dataset.index);
            button.closest('.value-container').remove();
            updateValues(index);
        }

        function handleValueEnter(event, index) {
            if (event.key === 'Enter') {
                event.preventDefault();
                addValue(index);
            }
        }

        function generateCombinations() {
            const tbody = document.getElementById('combinations-table-body');
            if (!tbody) return;

            const existingRows = Array.from(tbody.querySelectorAll('tr'));
            let existingCombinations = existingRows
                .filter(row => {
                    const statusInput = row.querySelector('input[name$="[status]"]');
                    return statusInput && statusInput.value === 'existing';
                })
                .map(row => {
                    const attrValuesInput = row.querySelector('input[name$="[attribute_values]"]');
                    const priceInput = row.querySelector('input[name$="[price]"]');
                    const stockInput = row.querySelector('input[name$="[stock]"]');
                    const idInput = row.querySelector('input[name$="[id]"]');
                    return {
                        attribute_values: JSON.parse(attrValuesInput ? attrValuesInput.value : '[]'),
                        price: priceInput ? parseFloat(priceInput.value) || 0 : 0,
                        stock: stockInput ? parseInt(stockInput.value) || 0 : 0,
                        id: idInput ? idInput.value : null,
                        status: 'existing'
                    };
                });

            const validAttributes = attributes.filter(attr => attr.name && attr.values.length > 0);

            if (validAttributes.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">Add attributes and their values to generate combinations.</td></tr>';
                return;
            }

            let allValues = validAttributes.map(attr => attr.values);
            let newCombinations = cartesianProduct(allValues);

            let updatedCombinations = newCombinations.map(combo => {
                const attrValueMapping = combo.map((val, j) => ({
                    attribute: validAttributes[j].name,
                    value: val
                }));

                const existingCombo = existingCombinations.find(exCombo => {
                    const exAttrValues = exCombo.attribute_values;
                    return attrValueMapping.every((item, idx) => {
                        const exItem = exAttrValues.find(ex => ex.attribute === item.attribute);
                        return exItem ? exItem.value === item.value : true;
                    });
                });

                return {
                    attribute_values: attrValueMapping,
                    price: existingCombo ? existingCombo.price : (document.getElementById('price')?.value || 0),
                    stock: existingCombo ? existingCombo.stock : (document.getElementById('stock')?.value || 0),
                    id: existingCombo ? existingCombo.id : null,
                    status: existingCombo ? 'existing' : 'new'
                };
            });

            tbody.innerHTML = '';

            if (updatedCombinations.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4">No valid combinations generated.</td></tr>';
                return;
            }

            updatedCombinations.forEach((combo, i) => {
                const comboDisplay = combo.attribute_values.map(item => `${item.attribute}: ${item.value}`).join(
                    ' / ');

                const row = `
                <tr>
                    <td>
                        <input type="hidden" name="combinations[${i}][attribute_values]" value='${JSON.stringify(combo.attribute_values)}'>
                        <input type="hidden" name="combinations[${i}][status]" value="${combo.status}">
                        ${combo.id ? `<input type="hidden" name="combinations[${i}][id]" value="${combo.id}">` : ''}
                        ${comboDisplay}
                    </td>
                    <td><input type="number" step="0.01" name="combinations[${i}][price]" value="${combo.price}" placeholder="Price" class="form-control" required></td>
                    <td><input type="number" name="combinations[${i}][stock]" value="${combo.stock}" placeholder="Stock" class="form-control" required></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeCombination(this)">Remove</button></td>
                </tr>
            `;
                tbody.insertAdjacentHTML('beforeend', row);
            });
        }

        function removeCombination(button) {
            const row = button.closest('tr');
            const idInput = row.querySelector('input[name$="[id]"]');

            if (idInput) {
                const index = row.querySelector('input[name$="[attribute_values]"]').name.match(/\[(\d+)\]/)[1];
                row.innerHTML = `
                <td colspan="4">
                    <input type="hidden" name="combinations[${index}][id]" value="${idInput.value}">
                    <input type="hidden" name="combinations[${index}][status]" value="deleted">
                </td>
            `;
            } else {
                row.remove();
            }
        }

        function cartesianProduct(arr) {
            if (arr.length === 0 || arr.some(subArr => subArr.length === 0)) {
                return [];
            }
            return arr.reduce((a, b) => {
                return a.flatMap(d => b.map(e => [...(Array.isArray(d) ? d : [d]), e]));
            }, [
                []
            ]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            generateCombinations();
        });
    </script>
@endsection
