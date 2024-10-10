@extends('admin.master')

@section('content')
<div class="card-header d-flex justify-content-between align-items-center">
    <div class="card-title">Danh Sách Biến Thể</div>
    <div>
        <a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-primary btn-sm btn-rounded d-flex align-items-center">

            <i class="bi bi-plus-circle me-2"></i> Thêm Mới
        </a>
    </div>
</div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tên Biến Thể</th>
                <th>Giá</th>
                <th>SKU</th>
                <th>Kho</th>

                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @if ($variants->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">Chưa có biến thể nào.</td>
                </tr>
            @else
                @foreach($variants as $variant)
                    <tr>
                        <td>{{ $variant->variant_name }}</td>
                        <td>{{ number_format($variant->price, 2) }} VNĐ</td>
                        <td>{{ $variant->sku }}</td>
                        <td>{{ $variant->stock }}</td>
                        <td>
                            <span class="badge {{ $variant->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($variant->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('variants.updateStatus', $variant->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $variant->status == 'active' ? 'btn-warning' : 'btn-success' }}">
                                    {{ $variant->status == 'active' ? 'Không Kích Hoạt' : 'Kích Hoạt' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
