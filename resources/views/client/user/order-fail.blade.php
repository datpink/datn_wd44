@if(session('error'))
    <div class="alert alert-danger">
        <strong>Lỗi:</strong> {{ session('error') }}
    </div>
@endif
