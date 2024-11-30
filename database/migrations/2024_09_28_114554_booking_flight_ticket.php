<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BookingFlightTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_flight_ticket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flight_ticket_id');
            $table->string('user_name');
            $table->string('phone');
            $table->string('email');
            $table->integer('num_of_passengers');
            $table->decimal('total_price', 15, 2);
            $table->timestamps();

            // Khóa ngoại liên kết với bảng flight_tickets
            $table->foreign('flight_ticket_id')->references('id')->on('flight_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa bảng khi rollback
        Schema::dropIfExists('booking_flight_ticket');
    }
}
