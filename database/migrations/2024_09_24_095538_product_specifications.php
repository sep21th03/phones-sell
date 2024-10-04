<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('screen_size')->nullable(); // Kích thước màn hình
            $table->string('screen_type')->nullable(); // Công nghệ màn hình
            $table->string('screen_resolution')->nullable(); // Độ phân giải màn hình
            $table->string('ram')->nullable(); // Dung lượng RAM
            $table->string('memory_card_slot')->nullable(); // Khe cắm thẻ nhớ
            $table->string('battery')->nullable(); // Pin
            $table->string('camera_front')->nullable(); // Camera trước
            $table->string('camera_rear')->nullable(); // Camera sau
            $table->string('sim')->nullable(); // Loại SIM
            $table->string('operating_system')->nullable(); // Hệ điều hành
            $table->string('chip')->nullable(); // Chip xử lý
            $table->string('pin')->nullable(); // Dung lượng pin
            $table->string('connectivity')->nullable(); // Kết nối
            $table->string('bluetooth')->nullable(); // Bluetooth
            $table->string('dimensions')->nullable(); // Kích thước
            $table->string('weight')->nullable(); // Trọng lượng
        
            // Khóa ngoại và các ràng buộc
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
