<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class ProductsImport implements ToModel, WithHeadingRow
{
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function model(array $row)
    {
        // Bỏ qua hàng rỗng
        if (empty(array_filter($row))) {
            return null;
        }

        // Gọi hàm extractImages để lấy và lưu ảnh từ Excel
        $imagePaths = $this->extractImages($this->filePath);

        return new Product([
            'catalogue_id' => $row['catalogue_id'],
            'brand_id' => $row['brand_id'],
            'name' => $row['name'],
            'slug' => $row['slug'],
            'sku' => $row['sku'],
            'description' => $row['description'],
            'image_url' => implode(',', $imagePaths), // Nếu có nhiều ảnh, lưu vào dưới dạng chuỗi
            'price' => $row['price'],
            'discount_price' => $row['discount_price'],
            'discount_percentage' => $row['discount_percentage'],
            'stock' => $row['stock'],
            'weight' => $row['weight'],
            'dimensions' => $row['dimensions'],
            'ratings_avg' => $row['ratings_avg'],
            'ratings_count' => $row['ratings_count'],
            'is_active' => $row['is_active'],
            'is_featured' => $row['is_featured'],
            'tomtat' => $row['tomtat'],
            'condition' => $row['condition'],
        ]);
    }

    // Cập nhật phương thức extractImages
    public function extractImages($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $images = $sheet->getDrawingCollection();
        $imagePaths = []; // Mảng lưu đường dẫn hình ảnh

        foreach ($images as $image) {
            if ($image instanceof Drawing) {
                $imageName = $image->getName();
                $imagePath = $image->getPath();
                $imageContents = file_get_contents($imagePath);
                $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
                $storedImagePath = 'images/' . uniqid() . '_' . $imageName . '.' . $imageExtension;
                Storage::put($storedImagePath, $imageContents);
                $imagePaths[] = $storedImagePath; // Thêm vào mảng đường dẫn hình ảnh
            } elseif ($image instanceof MemoryDrawing) {
                ob_start();
                call_user_func($image->getRenderingFunction(), $image->getImageResource());
                $imageContents = ob_get_contents();
                ob_end_clean();
                $imageExtension = $this->getMemoryDrawingExtension($image);
                $imageName = 'image_' . uniqid() . '.' . $imageExtension;
                $storedImagePath = 'images/' . $imageName;
                Storage::put($storedImagePath, $imageContents);
                $imagePaths[] = $storedImagePath; // Thêm vào mảng đường dẫn hình ảnh
            }
        }

        return $imagePaths; // Trả về mảng đường dẫn hình ảnh
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

    public function headingRow(): int
    {
        return 1;
    }
}
