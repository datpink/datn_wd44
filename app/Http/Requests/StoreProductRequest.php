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
            'sku' => 'unique:products,sku',
            'slug' => 'unique:products,slug',
            'catalogue_id' => 'required|exists:catalogues,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'condition' => 'required|in:new,used,refurbished',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'image_url' => 'nullable|image|max:2048',  // Định dạng ảnh, tối đa 2MB
            'images.*' => 'nullable|image|max:2048',    // Các file gallery, mỗi ảnh tối đa 2MB
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
            'tomtat' => 'nullable|string',
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
            'stock.required' => 'Số lượng là bắt buộc.',
            'stock.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'stock.numeric' => 'Số lượng phải là một số.',
            'condition.required' => 'Tình trạng sản phẩm là bắt buộc.',
            'condition.in' => 'Tình trạng sản phẩm không hợp lệ.',
            'weight.numeric' => 'Cân nặng phải là một số.',
            'weight.min' => 'Cân nặng phải lớn hơn hoặc bằng 0.',
            'dimensions.string' => 'Kích thước phải là một chuỗi ký tự.',
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
