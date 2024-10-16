<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty(array_filter($row))) {
            return null;
        }
        
        // Giả sử bạn đã lưu tệp Excel vào thư mục tạm thời
        $filePath = 'storage/app/public/temp/' . $row['file']; // Đường dẫn tới tệp Excel
        // Lưu ảnh từ Excel

        $this->extractImages($filePath);
        return new Product([
            'catalogue_id' => $row['catalogue_id'], // ID danh mục
            'brand_id' => $row['brand_id'], // ID thương hiệu
            'name' => $row['name'], // Tên
            'slug' => $row['slug'], // Slug
            'sku' => $row['sku'], // SKU
            'description' => $row['description'], // Mô tả
            'image_url' => $row['image_url'], // Đường dẫn ảnh
            'price' => $row['price'], // Giá
            'discount_price' => $row['discount_price'], // Giá giảm
            'discount_percentage' => $row['discount_percentage'], // Phần trăm giảm giá
            'stock' => $row['stock'], // Số lượng tồn kho
            'weight' => $row['weight'], // Trọng lượng
            'dimensions' => $row['dimensions'], // Kích thước
            'ratings_avg' => $row['ratings_avg'], // Điểm đánh giá trung bình
            'ratings_count' => $row['ratings_count'], // Số lượng đánh giá
            'is_active' => $row['is_active'], // Trạng thái hoạt động
            'is_featured' => $row['is_featured'], // Trạng thái nổi bật
            'tomtat' => $row['tomtat'], // Tóm tắt
            'condition' => $row['condition'], // Tình trạng
        ]);
    }

    public function headingRow(): int
    {
        return 1; // Đặt dòng đầu tiên làm tiêu đề
    }
    public function extractImages($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $images = $sheet->getDrawingCollection();

        foreach ($images as $image) {
            if ($image instanceof Drawing) {
                // Lấy thông tin về ảnh
                $imageName = $image->getName();
                $imagePath = $image->getPath();
                $imageContents = file_get_contents($imagePath);
                $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);

                // Lưu ảnh vào storage/images
                $storedImagePath = 'images/' . $imageName . '.' . $imageExtension;
                Storage::put($storedImagePath, $imageContents);
            } elseif ($image instanceof MemoryDrawing) {
                // Xử lý các ảnh từ MemoryDrawing
                ob_start();
                call_user_func($image->getRenderingFunction(), $image->getImageResource());
                $imageContents = ob_get_contents();
                ob_end_clean();

                $imageExtension = $this->getMemoryDrawingExtension($image);
                $imageName = 'image_' . uniqid() . '.' . $imageExtension;
                $storedImagePath = 'images/' . $imageName;

                // Lưu ảnh vào storage/images
                Storage::put($storedImagePath, $imageContents);
            }
        }
    }
    private function getMemoryDrawingExtension(MemoryDrawing $drawing)
    {
        switch ($drawing->getMimeType()) {
            case MemoryDrawing::MIMETYPE_PNG:
                return 'png';
            case MemoryDrawing::MIMETYPE_GIF:
                return 'gif';
            case MemoryDrawing::MIMETYPE_JPEG:
                return 'jpg';
            default:
                return 'png';
        }
    }
}
