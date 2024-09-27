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
        Schema::create('product_spe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('rom')->nullable();
            $table->string('color')->nullable();
            $table->string('screen_type')->nullable();
            $table->string('battery')->nullable();
            $table->string('camera_front')->nullable();
            $table->string('camera_rear')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('chip')->nullable();
            $table->string('pin')->nullable();
            $table->string('connectivity')->nullable();
            $table->string('bluetooth')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('weight')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_spe');
    }
};
