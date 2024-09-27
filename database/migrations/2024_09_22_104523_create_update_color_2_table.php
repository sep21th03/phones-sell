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
    Schema::table('product_specifications', function (Blueprint $table) {
        $table->enum('color', ['Đỏ', 'Đen', 'Trắng', 'Hồng', 'Bạch Kim', 'Bạc', 'Tím', 'Xanh Dương', 'Vàng', 'Vàng Kim'])->change();
    });
}

public function down(): void
{
    Schema::table('product_specifications', function (Blueprint $table) {
        
        $table->enum('color', ['Red', 'Black', 'White'])->change();
    });
}

};
