<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Carorder extends Migration
{
    public function up()
    {
        Schema::create('carorder', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade'); // Liên kết với bảng cars
            $table->string('user_name');
            $table->string('phone');
            $table->string('email');
            $table->date('start_date');
            $table->date('end_date');
            // Các thông tin bổ sung từ bảng cars
            $table->string('car_name');
            $table->string('car_brand');
            $table->string('license_plate');
            $table->string('type');
            $table->integer('seats');
            $table->decimal('price_per_day', 8, 2); // Giá mỗi ngày
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carorder');
    }
}
