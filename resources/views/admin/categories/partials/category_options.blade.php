@foreach($categories as $category)
    <option value="{{ $category->id }}">{{ $prefix }}{{ $category->name }}</option>
    @if($category->children->isNotEmpty())
        @include('admin.catalogues.partials.category_options', ['categories' => $category->children, 'prefix' => $prefix . '--- '])
    @endif
@endforeach