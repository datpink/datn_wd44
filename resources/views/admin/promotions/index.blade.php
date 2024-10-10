@extends('admin.master')

@section('title', 'Thêm mới mã giảm giá')

@section('content')
    <div class="main-admin">
        <div class="container mt-4">
            <h1>Danh sách mã giảm giá </h1>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('errors'))
                <div class="alert alert-danger">{{ session('errors') }}</div>
            @endif

            <a href="{{ route('promotions.create') }}" class="btn btn-primary mb-3">Thêm Mã Giảm Giá</a>

            <table class="table table-striped centered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Mức Giảm Giá</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Bắt Đầu</th>
                        <th>Ngày Kết Thúc</th>
                        <th>Ngày Sửa Mã</th>
                        <th colspan="2">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promotions as $promotion)
                        <tr>
                            <td>{{ $promotion->id }}</td>
                            <td>{{ $promotion->code }}</td>
                            <td>{{ $promotion->discount_value }}%</td>
                            <td>
                    @if ($promotion->status == 'active')
                        <span class="badge badge-success">Kích hoạt</span>
                    @elseif ($promotion->status == 'inactive')
                        <span class="badge badge-danger">Không kích hoạt</span>
                        
                    @endif
                </td>
                            <td>{{ $promotion->start_date}}</td>
                            <td>{{ $promotion->end_date}}</td>
                            <td>{{ $promotion->updated_at ?? 'Trống'  }}</td>
                            <td>
                                <a href="{{ route('promotions.edit', $promotion->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Bạn Muốn Xóa Mã Giảm giá Này?')) {
                    this.submit();
                }
            });
        });
    </script>

@endsection
