<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Tạo bảng regions
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên miền: Bắc, Trung, Nam
            $table->timestamps();
        });

        // Tạo bảng cities và liên kết với bảng regions
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên thành phố
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->timestamps();
        });

        // Thêm dữ liệu mẫu vào bảng regions và cities
        $this->seedRegionsAndCities();
    }

    public function down()
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('regions');
    }

    // Seeder cho dữ liệu miền và thành phố
    private function seedRegionsAndCities()
    {
        // Dữ liệu các miền và thành phố
        $regions = [
            'Miền Bắc' => [
                'Hà Nội', 'Hà Giang', 'Cao Bằng', 'Bắc Kạn', 'Tuyên Quang', 'Lào Cai', 'Điện Biên', 'Lai Châu', 'Sơn La',
                'Yên Bái', 'Hòa Bình', 'Thái Nguyên', 'Lạng Sơn', 'Quảng Ninh', 'Bắc Giang', 'Phú Thọ', 'Vĩnh Phúc',
                'Bắc Ninh', 'Hải Dương', 'Hải Phòng', 'Hưng Yên', 'Thái Bình', 'Hà Nam', 'Nam Định', 'Ninh Bình'
            ],
            'Miền Trung' => [
                'Thanh Hóa', 'Nghệ An', 'Hà Tĩnh', 'Quảng Bình', 'Quảng Trị', 'Thừa Thiên Huế', 'Đà Nẵng', 'Quảng Nam',
                'Quảng Ngãi', 'Bình Định', 'Phú Yên', 'Khánh Hòa', 'Ninh Thuận', 'Bình Thuận', 'Kon Tum', 'Gia Lai', 'Đắk Lắk', 'Đắk Nông', 'Lâm Đồng'
            ],
            'Miền Nam' => [
                'Bình Phước', 'Tây Ninh', 'Bình Dương', 'Đồng Nai', 'Bà Rịa - Vũng Tàu', 'TP Hồ Chí Minh', 'Long An', 'Tiền Giang',
                'Bến Tre', 'Trà Vinh', 'Vĩnh Long', 'Đồng Tháp', 'An Giang', 'Kiên Giang', 'Cần Thơ', 'Hậu Giang', 'Sóc Trăng', 'Bạc Liêu', 'Cà Mau'
            ]
        ];

        // Thêm dữ liệu miền vào bảng regions và các thành phố vào bảng cities
        foreach ($regions as $regionName => $cities) {
            $regionId = DB::table('regions')->insertGetId(['name' => $regionName]);

            foreach ($cities as $city) {
                DB::table('cities')->insert([
                    'name' => $city,
                    'region_id' => $regionId,
                ]);
            }
        }
    }
};
