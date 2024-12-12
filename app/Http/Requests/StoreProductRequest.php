<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này hay không.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Quy tắc xác thực áp dụng cho yêu cầu.
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'sku' => 'required|unique:products,sku|regex:/^[a-zA-Z0-9\-]+$/', // Kiểm tra định dạng SKU
            'slug' => 'required|unique:products,slug|regex:/^[a-z0-9\-]+$/', // Kiểm tra định dạng Slug
            'catalogue_id' => 'required|exists:catalogues,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price', // Kiểm tra discount_price nếu có
            'stock' => 'required|numeric|min:0|max:1000000', // Giới hạn stock từ 0 đến 1 triệu
            'condition' => 'required|in:new,used,refurbished',
            'image_url' => 'nullable|image|max:2048|mimes:jpeg,png,jpg', // Kiểm tra định dạng ảnh
            'images.*' => 'nullable|image|max:2048|mimes:jpeg,png,jpg',  // Kiểm tra ảnh gallery
            'description' => 'nullable|string|max:1000', // Giới hạn độ dài mô tả
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
            'tomtat' => 'nullable|string|max:500', // Giới hạn độ dài tóm tắt
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'sku.unique' => 'SKU đã tồn tại, vui lòng chọn SKU khác.',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác.',
            'catalogue_id.required' => 'Danh mục là bắt buộc.',
            'catalogue_id.exists' => 'Danh mục không hợp lệ.',
            'price.required' => 'Giá là bắt buộc.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'price.numeric' => 'Giá phải là một số.',
            'discount_price.numeric' => 'Giá giảm phải là một số.',
            'discount_price.min' => 'Giá khuyến mãi không được âm.',
            'discount_price.lte' => 'Giá giảm phải nhỏ hơn hoặc bằng giá gốc.',
            'stock.required' => 'Số lượng là bắt buộc.',
            'stock.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'stock.numeric' => 'Số lượng phải là một số.',
            'stock.max' => 'Số lượng không được vượt quá 1 triệu.',
            'condition.required' => 'Tình trạng sản phẩm là bắt buộc.',
            'condition.in' => 'Tình trạng sản phẩm không hợp lệ.',
            'image_url.image' => 'Ảnh sản phẩm phải là file hình ảnh.',
            'image_url.max' => 'Ảnh sản phẩm không được vượt quá 2MB.',
            'images.*.image' => 'Các file gallery phải là hình ảnh.',
            'images.*.max' => 'Kích thước mỗi ảnh gallery không được vượt quá 2MB.',
            'description.string' => 'Mô tả phải là một chuỗi.',
            'is_active.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'is_active.boolean' => 'Trạng thái sản phẩm phải là giá trị boolean.',
            'is_featured.boolean' => 'Nổi bật phải là giá trị boolean.',
            'tomtat.string' => 'Tóm tắt phải là một chuỗi.',
        ];
    }

}
