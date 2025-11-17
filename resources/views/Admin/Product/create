@extends('Admin/layout')
@section('title', 'Create - product')

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

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="two-columns">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                placeholder="Enter product name">
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="">Select status</option>
                <option value="1" {{ old('status')==='1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status')==='0' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" class="form-control" name="image" id="image">
            @error('image')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="banner_image">Banner Images</label>
            <input type="file" class="form-control" name="banner_image[]" id="banner_image" multiple>
            @error('banner_image')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="is_featured">Is Featured</label>
            <select class="form-control" name="is_featured" id="is_featured">
                <option value="">Select</option>
                <option value="1" {{ old('is_featured')==='1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('is_featured')==='0' ? 'selected' : '' }}>No</option>
            </select>
            @error('is_featured')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="{{ old('stock') }}"
                placeholder="Enter stock">
            @error('stock')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="weight">Weight</label>
            <input type="number" class="form-control" name="weight" id="weight" value="{{ old('weight') }}"
                placeholder="Enter weight">
            @error('weight')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}"
                placeholder="Enter price">
            @error('price')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="special_price">Special Price</label>
            <input type="number" class="form-control" name="special_price" value="{{ old('special_price') }}"
                id="special_price" placeholder="Enter special price">
            @error('special_price')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="special_price_from">Special Price From</label>
            <input type="date" class="form-control" name="special_price_from" value="{{ old('special_price_from') }}"
                id="special_price_from">
            @error('special_price_from')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="special_price_to">Special Price To</label>
            <input type="date" class="form-control" name="special_price_to" value="{{ old('special_price_to') }}"
                id="special_price_to">
            @error('special_price_to')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-select form-control" id="category" name="category[]" multiple>
                <option value="" disabled>Select Categories</option>
                @foreach($categorys as $category)
                <option value="{{ $category->id }}" {{ (collect(old('category', $selectedCategories ?? []))->
                    contains($category->id)) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

    </div>
    <div class="form-group">
        <label for="short_description">Short Description</label>
        <input class="form-control" name="short_description" id="short_description"
            value="{{ old('short_description') }}" rows="3" placeholder="Enter short description">
        @error('short_description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"
            placeholder="Enter description">{{ old('description') }}</textarea>
        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="related_product">Related Product</label>
        <select class="form-select form-control" id="related_product" name="related_product[]" multiple>
            <option value="" disabled>Select related products</option>
            @foreach($products as $product)
            <option value="{{ $product->id }}" {{ in_array($product->id, old('related_product', [])) ? 'selected' : ''
                }}>{{ $product->name }}</option>
            @endforeach
        </select>
        @error('related_product')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_tag">Meta Tag</label>
        <input type="text" class="form-control" name="meta_tag" id="meta_tag" value="{{ old('meta_tag') }}"
            placeholder="Enter meta tag">
        @error('meta_tag')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_title">Meta Title</label>
        <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
            placeholder="Enter meta title">
        @error('meta_title')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="meta_description">Meta Description</label>
        <textarea class="form-control" name="meta_description" id="meta_description" rows="3"
            placeholder="Enter meta description">{{ old('description') }}</textarea>
        @error('meta_description')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div id="attribute-section" class="attribute-section">
        <h4>Add Attributes</h4>
        <div id="attributes-container"></div>
        <button type="button" class="btn btn-primary" onclick="addAttribute()">Add Attribute</button>
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
            <tbody id="combinations-table-body"></tbody>
        </table>
        @error('combinations')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="card-action">
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src=""></script>

<script>
    CKEDITOR.replace('description');
    CKEDITOR.replace('meta_description');
</script>
<script>
    let attributeIndex = 0;
    let attributes = @json(old('attributes', isset($existingAttributes) ? $existingAttributes : []));
    attributes = attributes.map((attr, index) => ({
        name: attr.name || '',
        values: Array.isArray(attr.values) ? [...new Set(attr.values.filter(val => val.trim() !== ''))] : [],
        originalIndex: index
    }));
    const oldCombinations = @json(old('combinations', isset($existingCombinations) ? $existingCombinations : []));

    console.log('Initial attributes:', attributes);
    console.log('Initial oldCombinations:', oldCombinations);

    function addAttribute(name = '', values = []) {
        if (name && attributes.some(attr => attr.name.toLowerCase() === name.toLowerCase() && attr.originalIndex !== attributeIndex)) {
            alert('This attribute name already exists!');
            return;
        }

        const container = document.getElementById('attributes-container');
        if (!container) {
            console.error('attributes-container not found');
            return;
        }

        const div = document.createElement('div');
        div.classList.add('form-group', 'border', 'p-3', 'mb-3');
        div.dataset.index = attributeIndex;
    
        // Ensure unique values
        values = [...new Set(values.filter(val => val.trim() !== ''))];

        div.innerHTML = `
            <div>
                <div class="d-flex align-items-center mb-2">
                    <input type="text" name="attributes[${attributeIndex}][name]" value="${name}" placeholder="Attribute name (e.g., Color)" class="form-control attribute-name mr-2" required oninput="updateAttributeName(${attributeIndex}, this.value)">
                    <button type="button" class="btn btn-sm btn-danger" id="removeAttribute">X</button>
                </div>
                <div class="attribute-values-wrapper" id="values-wrapper-${attributeIndex}">
                    ${values.map(val => `
                        <div class="value-container">
                            <input type="text" name="attributes[${attributeIndex}][values][]" value="${val}" class="form-control attribute-value-input" required placeholder="Value (e.g., Red)" oninput="updateValues(${attributeIndex})">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeValue(this)">x</button>
                        </div>
                    `).join('')}
                    <div class="value-container">
                        <input type="text" name="attributes[${attributeIndex}][values][]" class="form-control attribute-value-input" placeholder="Value (e.g., Red)" oninput="updateValues(${attributeIndex})" onkeydown="handleValueEnter(event, this, ${attributeIndex})">
                        <button type="button" class="btn btn-sm btn-primary" onclick="addValue(${attributeIndex})">+</button>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(div);
        attributes.push({ name, values, originalIndex: attributeIndex });
        attributeIndex++;
          let removeButtons = document.querySelectorAll("#removeAttribute");
        removeButtons.forEach(button => {
            button.addEventListener('click', () => removeAttribute(button));
        });
        if (!skipGenerate) {
            generateCombinations();
        }
        // generateCombinations();
    }

    function addValue(index) {
        const wrapper = document.getElementById(`values-wrapper-${index}`);
        const lastInput = wrapper.querySelector('.value-container:last-child .attribute-value-input');
        if (lastInput.value.trim() === '') {
            alert('Please enter a value before adding another!');
            return;
        }

        const valueContainer = document.createElement('div');
        valueContainer.className = 'value-container';
        valueContainer.innerHTML = `
            <input type="text" name="attributes[${index}][values][]" class="form-control attribute-value-input" placeholder="Value (e.g., Red)" oninput="updateValues(${index})" onkeydown="handleValueEnter(event, this, ${index})">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeValue(this)">x</button>
        `;
       wrapper.insertBefore(valueContainer, wrapper.firstChild);

        updateValues(index);
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
    // << Change this line >>
    const firstValueRow = wrapper.querySelector('.value-container');
    wrapper.insertBefore(valueContainer, firstValueRow);

    lastInput.value = '';
    updateValues(index);
}


    function updateAttributeName(index, name) {
        console.log('Updating attribute name:', { index, name });
        if (name && attributes.some((attr, i) => i !== index && attr.name.toLowerCase() === name.toLowerCase())) {
            alert('This attribute name already exists!');
            document.querySelector(`.form-group[data-index="${index}"] .attribute-name`).value = attributes[index].name;
            return;
        }
        attributes[index].name = name.trim();
        generateCombinations();
    }

    function updateValues(index) {
        console.log('Updating values for attribute index:', index);
        const valueInputs = document.querySelectorAll(`#values-wrapper-${index} input[name="attributes[${index}][values][]"]`);
        const values = [...new Set(Array.from(valueInputs)
            .map(input => input.value.trim())
            .filter(val => val !== ''))];
        if (values.length < valueInputs.length) {
            // alert('Duplicate or empty values are not allowed!');
            return;
        }
        attributes[index].values = values;
        console.log('Updated values:', values);
        generateCombinations();
    }
//   let removeButtons = document.querySelectorAll("#removeAttribute");
//     removeButtons.forEach(button => {
//         button.addEventListener('click', () => removeAttribute(button));
//     });
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
        console.log('Removing value');
        const index = parseInt(button.closest('.form-group').dataset.index);
        const valueContainer = button.closest('.value-container');
        valueContainer.remove();
        updateValues(index);
    }

    function handleValueEnter(event, input, index) {
        if (event.key === 'Enter' || event.key === 'Tab') {
            event.preventDefault();
            if (input.value.trim() === '') return;
            addValue(index);
            const newInput = input.parentNode.nextSibling.querySelector('.attribute-value-input');
            if (newInput) newInput.focus();
        }
    }

    function generateCombinations() {
        console.log('Generating combinations with attributes:', attributes);
        const tbody = document.getElementById('combinations-table-body');
        if (!tbody) {
            console.error('combinations-table-body not found');
            return;
        }
        tbody.innerHTML = '';

        const validAttributes = attributes.filter(attr => attr.name && attr.values.length > 0);
        if (validAttributes.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4">Add attributes and their values to generate combinations.</td></tr>';
            console.log('No valid attributes found');
            return;
        }

        let allValues = validAttributes.map(attr => attr.values);
        console.log('All values for combinations:', allValues);
        let combinations = cartesianProduct(allValues);

        console.log('Generated combinations:', combinations);

        if (combinations.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4">No valid combinations generated.</td></tr>';
            return;
        }

        const defaultPrice = document.getElementById('price')?.value || 0;
        const defaultStock = document.getElementById('stock')?.value || 0;

        combinations.forEach((combo, i) => {
            const comboDisplay = combo.map((val, j) => `${validAttributes[j].name}: ${val}`).join(' / ');
            const attrValueMapping = combo.map((val, j) => ({
                attribute: validAttributes[j].name,
                value: val
            }));

            const oldCombo = oldCombinations.find(oc => {
                const ocValues = JSON.parse(oc.attribute_values || '[]');
                return ocValues.every((v, idx) => v.attribute === attrValueMapping[idx]?.attribute && v.value === attrValueMapping[idx]?.value);
            }) || {};
            const oldPrice = oldCombo.price !== undefined ? oldCombo.price : 0;
const oldStock = oldCombo.stock !== undefined ? oldCombo.stock : 0;

            const status = oldCombo.id ? 'existing' : 'new';

            const row = `
                <tr>
                    <td>
                        <input type="hidden" name="combinations[${i}][attribute_values]" value='${JSON.stringify(attrValueMapping)}'>
                        <input type="hidden" name="combinations[${i}][status]" value="${status}">
                        ${oldCombo.id ? `<input type="hidden" name="combinations[${i}][id]" value="${oldCombo.id}">` : ''}
                        ${comboDisplay}
                    </td>
                    <td><input type="number" step="0.01" name="combinations[${i}][price]" value="${oldPrice}" placeholder="Price" class="form-control" required></td>
                    <td><input type="number" name="combinations[${i}][stock]" value="${oldStock}" placeholder="Stock" class="form-control" required></td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeCombination(this)">Remove</button></td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
        });
    }

    function removeCombination(button) {
        console.log('Removing combination');
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

        const rows = document.querySelectorAll('#combinations-table-body tr');
        rows.forEach((row, i) => {
            const hiddenInput = row.querySelector('input[name$="[attribute_values]"]');
            const priceInput = row.querySelector('input[name$="[price]"]');
            const stockInput = row.querySelector('input[name$="[stock]"]');
            const statusInput = row.querySelector('input[name$="[status]"]');
            const idInput = row.querySelector('input[name$="[id]"]');
            if (hiddenInput) hiddenInput.name = `combinations[${i}][attribute_values]`;
            if (priceInput) priceInput.name = `combinations[${i}][price]`;
            if (stockInput) stockInput.name = `combinations[${i}][stock]`;
            if (statusInput) statusInput.name = `combinations[${i}][status]`;
            if (idInput) idInput.name = `combinations[${i}][id]`;
        });
    }

    function cartesianProduct(arr) {
        if (arr.length === 0 || arr.some(subArr => subArr.length === 0)) {
            return [];
        }
        return arr.reduce((a, b) => {
            return a.flatMap(d => b.map(e => [...(Array.isArray(d) ? d : [d]), e]));
        }, [[]]);
    }

    document.getElementById('price')?.addEventListener('input', function () {
        const price = this.value || 0;
        console.log('Updating price for all combinations:', price);
        const rows = document.querySelectorAll('#combinations-table-body tr');
        rows.forEach(row => {
            const priceInput = row.querySelector('input[name$="[price]"]');
            if (priceInput) priceInput.value = price;
        });
    });

    document.getElementById('stock')?.addEventListener('input', function () {
        const stock = this.value || 0;
        console.log('Updating stock for all combinations:', stock);
        const rows = document.querySelectorAll('#combinations-table-body tr');
        rows.forEach(row => {
            const stockInput = row.querySelector('input[name$="[stock]"]');
            if (stockInput) stockInput.value = stock;
        });
    });

    window.onload = function () {
        console.log('Page loaded, initializing attributes');
        if (attributes.length > 0) {
            attributes.forEach(attr => addAttribute(attr.name, attr.values));
        } else {
            addAttribute();
        }
    };
</script>
@endsection