@extends('admin.master')

@section('title', 'Thùng Rác Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 rounded shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-3">Thùng Rác Danh Mục</div>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên</th>
                                    {{-- <th>Hình ảnh</th> --}}
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                       
                                        <td>{{ $category->deleted_at ? $category->deleted_at->format('d-m-Y') : 'Chưa xóa' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('categories.restore', $category->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success rounded-pill btn-sm"
                                                    onclick="return confirm('Khôi phục lại danh mục?')">
                                                    <i class="fas fa-undo"></i> Khôi phục
                                                </button>
                                            </form>
                                            <form action="{{ route('categories.forceDelete', $category->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger rounded-pill btn-sm"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa cứng không?');">
                                                    <i class="fas fa-trash"></i> Xóa cứng
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có danh mục nào trong thùng rác.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
