<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FlightTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');      // Số hiệu chuyến bay
            $table->string('airline');            // Hãng hàng không
            $table->string('departure_city');     // Thành phố xuất phát
            $table->string('arrival_city');       // Thành phố đến
            $table->timestamp('departure_time')->nullable();  // Ngày giờ khởi hành
            $table->timestamp('arrival_time')->nullable();    // Ngày giờ đến
            $table->decimal('price', 10, 2);      // Giá vé
            $table->integer('available_seats');   // Số lượng ghế còn trống
            $table->boolean('status')->default(1); // Trạng thái vé (1: Còn vé, 0: Hết vé)
            $table->timestamps();                // Ngày tạo và cập nhật
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flight_tickets');
    }
}
