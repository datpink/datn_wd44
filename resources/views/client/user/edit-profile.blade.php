@extends('client.master')

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
    <style>
        select.form-control,
        input.form-control {
            border: 1px solid #ced4da;
            /* Màu xám nhạt */
            border-radius: 4px;
            /* Bo góc */
            padding: 8px;
            /* Tạo khoảng cách trong */
            box-shadow: none;
            /* Loại bỏ shadow nếu có */
            outline: none;
            /* Loại bỏ viền khi focus */
        }

        select.form-control:focus,
        input.form-control:focus {
            border-color: #dc3545;
            /* Màu đỏ khi focus */
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
            /* Hiệu ứng khi focus */
        }
    </style>
    @include('components.breadcrumb-client2')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-4 border-0 rounded">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Chỉnh sửa hồ sơ</h3>
                        <form action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <!-- Name -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label"><strong>Tên đầy đủ</strong></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" required>
                                    </div>
                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label"><strong>Số điện thoại</strong></label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $user->phone }}">
                                    </div>

                                    <!-- Address -->
                                    <div class="">
                                        <!-- Dropdown chọn tỉnh -->
                                        <p class="form-row form-row-wide validate-required" data-priority="20">
                                            <label>Tỉnh&nbsp;<abbr class="required" title="required">*</abbr></label>
                                            <span class="kobolg-input-wrapper">
                                                <select name="province" id="province" class="form-control" required>
                                                    <option value="">Chọn tỉnh</option>
                                                    @foreach ($provinces as $provinceOption)
                                                        <option value="{{ $provinceOption->id }}"
                                                            @if($province && old('province', $province->id ?? null) == $provinceOption->id) selected @endif>
                                                            {{ $provinceOption->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </p>

                                        <!-- Dropdown chọn huyện -->
                                        <p class="form-row form-row-wide validate-required" data-priority="30">
                                            <label>Huyện&nbsp;<abbr class="required" title="required">*</abbr></label>
                                            <span class="kobolg-input-wrapper">
                                                <select name="district" id="district" class="form-control" required>
                                                    <option value="">Chọn huyện</option>
                                                    @if ($district)
                                                        <option value="{{ $district->id }}" selected>{{ $district->name }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </span>
                                        </p>

                                        <!-- Dropdown chọn xã/phường -->
                                        <p class="form-row form-row-wide validate-required" data-priority="40">
                                            <label>Xã/Phường&nbsp;<abbr class="required" title="required">*</abbr></label>
                                            <span class="kobolg-input-wrapper">
                                                <select name="ward" id="ward" class="form-control" required>
                                                    <option value="">Chọn xã/phường</option>
                                                    @if ($ward)
                                                        <option value="{{ $ward->id }}" selected>{{ $ward->name }}
                                                        </option>
                                                    @endif
                                                </select>
                                            </span>
                                        </p>

                                    </div>



                                </div>

                                <div class="col-md-4 text-center">
                                    <!-- Image -->
                                    <div class="mb-4 text-center">
                                        <label for="image" class="form-label"><strong>Hình ảnh hồ sơ</strong></label>
                                        <div class="position-relative d-flex flex-column align-items-center">
                                            @if ($user->image)
                                                <img id="currentImage" src="{{ asset('storage/' . $user->image) }}"
                                                    alt="{{ $user->name }}" class="img-thumbnail mb-2"
                                                    style="max-width: 150px; border-radius: 50%;">
                                                <p class="form-text">Hình ảnh hiện tại</p>
                                            @else
                                                <div class="mb-2"
                                                    style="width: 150px; height: 150px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <span class="text-muted">Không có hình ảnh</span>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control-file position-absolute" id="image"
                                                name="image" accept="image/*"
                                                style="top: 0; left: 0; width: 150px; height: 150px; opacity: 0;">
                                            <button type="button" class="btn btn-danger mt-2" style="width: 150px;"
                                                onclick="document.getElementById('image').click();">Thay đổi hình
                                                ảnh</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill shadow">Lưu thay
                                    đổi</button>
                                <a href="{{ route('profile.show') }}"
                                    class="btn btn-outline-danger btn-lg rounded-pill shadow">Quay lại</a>
                            </div>
                            <input type="hidden" id="full_address" name="full_address" value="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script for image preview -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cập nhật danh sách huyện khi chọn tỉnh
            $("#province").change(function() {
                const provinceId = $(this).val();

                if (provinceId) {
                    $.ajax({
                        url: `{{ route('getDistricts', ':provinceId') }}`.replace(":provinceId",
                            provinceId),
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                const $district = $("#district");
                                $district.empty().append(
                                    '<option value="">Chọn huyện</option>');

                                response.districts.forEach((district) => {
                                    $district.append(
                                        `<option value="${district.id}">${district.name}</option>`
                                    );
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert("Đã xảy ra lỗi khi tải danh sách huyện.");
                        },
                    });
                } else {
                    $("#district").empty().append('<option value="">Chọn huyện</option>');
                }
            });

            // Cập nhật danh sách huyện khi chọn tỉnh
            $("#province").change(function() {
                const provinceId = $(this).val();

                if (provinceId) {
                    $.ajax({
                        url: `{{ route('getDistricts', ':provinceId') }}`.replace(":provinceId",
                            provinceId),
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                const $district = $("#district");
                                $district.empty().append(
                                    '<option value="">Chọn huyện</option>');

                                response.districts.forEach((district) => {
                                    $district.append(
                                        `<option value="${district.id}">${district.name}</option>`
                                    );
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert("Đã xảy ra lỗi khi tải danh sách huyện.");
                        },
                    });
                } else {
                    $("#district").empty().append('<option value="">Chọn huyện</option>');
                }
            });

            // Cập nhật danh sách xã/phường khi chọn huyện
            $("#district").change(function() {
                const districtId = $(this).val();

                if (districtId) {
                    $.ajax({
                        url: `{{ route('getWards', ':districtId') }}`.replace(":districtId",
                            districtId),
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                const $ward = $("#ward");
                                $ward.empty().append(
                                    '<option value="">Chọn xã/phường</option>');

                                response.wards.forEach((ward) => {
                                    $ward.append(
                                        `<option value="${ward.id}">${ward.name}</option>`
                                    );
                                });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert("Đã xảy ra lỗi khi tải danh sách xã/phường.");
                        },
                    });
                } else {
                    $("#ward").empty().append('<option value="">Chọn xã/phường</option>');
                }
            });


            const provinceSelect = document.querySelector('#province');
            const districtSelect = document.querySelector('#district');
            const wardSelect = document.querySelector('#ward');
            const fullAddressInput = document.querySelector('#full_address');

            // Lắng nghe sự thay đổi của các dropdown
            provinceSelect.addEventListener('change', updateFullAddress);
            districtSelect.addEventListener('change', updateFullAddress);
            wardSelect.addEventListener('change', updateFullAddress);

            function updateFullAddress() {
                const provinceId = provinceSelect.value;
                const districtId = districtSelect.value;
                const wardId = wardSelect.value;

                let fullAddress = '';

                // Kiểm tra xem các giá trị có hợp lệ không và tạo chuỗi gộp
                if (provinceId) {
                    fullAddress += provinceSelect.options[provinceSelect.selectedIndex].text;
                }
                if (districtId) {
                    fullAddress += ' - ' + districtSelect.options[districtSelect.selectedIndex].text;
                }
                if (wardId) {
                    fullAddress += ' - ' + wardSelect.options[wardSelect.selectedIndex].text;
                }

                // Cập nhật giá trị cho input ẩn
                fullAddressInput.value = fullAddress;
            }


        });
    </script>
@endsection
