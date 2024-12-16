@extends('admin.master')

@section('title', 'Cập Nhật Danh Mục')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Cập Nhật Danh Mục</div>
                    <a href="{{ route('catalogues.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>

                <div class="card-body mt-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('catalogues.update', $catalogue) }}" method="POST" enctype="multipart/form-data"
                        id="catalogueForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="name" class="form-label">Tên danh mục:</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $catalogue->name) }}" oninput="generateSlug()">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="card-body">
                                    <label for="slug" class="form-label">Slug:</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        value="{{ old('slug', $catalogue->slug) }}" readonly>
                                    @error('slug')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-3">
                                    Cập nhật
                                </button>
                            </div>

                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="status" class="form-label">Trạng thái:</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active"
                                            {{ old('status', $catalogue->status) === 'active' ? 'selected' : '' }}>
                                            Kích hoạt
                                        </option>
                                        <option value="inactive"
                                            {{ old('status', $catalogue->status) === 'inactive' ? 'selected' : '' }}>
                                            Không kích hoạt
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="card-body">
                                    <label for="image" class="form-label">Hình ảnh:</label>
                                    <input type="file" name="image" id="image" class="form-control"
                                        onchange="previewImage(event)">

                                    @if ($catalogue->image)
                                        <img id="imagePreview" src="{{ asset('storage/' . $catalogue->image) }}"
                                            alt="{{ $catalogue->name }}" style="width: 100px; margin-top: 10px;">
                                    @else
                                        <p class="text-danger mt-2">Hình ảnh không tồn tại</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function generateSlug() {
            let name = document.getElementById('name').value;
            let slug = name.toLowerCase();

            // Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');

            // Xóa các ký tự đặc biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');

            // Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");

            // Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');

            // Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');

            // Cập nhật giá trị cho input slug
            document.getElementById('slug').value = slug;
        }
    </script>

    <script>
        let isChanged = false; // Biến để theo dõi sự thay đổi

        function previewImage(event) {
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    isChanged = true; // Đánh dấu rằng có sự thay đổi
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '{{ asset('storage/' . $catalogue->image) }}';
            }
        }
    </script>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 1500
            });
        </script>
    @endif
@endsection
