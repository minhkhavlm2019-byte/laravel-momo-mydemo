<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('DonHangID')
                  ->constrained('don_hangs')
                  ->onDelete('cascade');
            $table->foreignId('SanPhamID')
                  ->constrained('san_phams')
                  ->onDelete('cascade');
            $table->integer('SoLuong')->default(1);
            $table->decimal('GiaLucMua', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('chi_tiet_don_hangs');
    }
};

