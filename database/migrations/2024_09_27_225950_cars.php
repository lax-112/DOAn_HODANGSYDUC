<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id(); // Tạo ID tự tăng
            $table->string('name'); // Tên xe
            $table->string('brand'); // Hãng xe
            $table->string('license_plate')->unique(); // Biển số xe (độc nhất)
            $table->string('type'); // Loại xe (xe du lịch, xe khách, v.v.)
            $table->integer('seats'); // Số ghế
            $table->decimal('price_per_day', 10, 2); // Giá thuê mỗi ngày
            $table->boolean('is_available')->default(true); // Trạng thái sẵn sàng (true = có sẵn, false = không có sẵn)
            $table->timestamps(); // Tạo trường created_at và updated_at tự động
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
