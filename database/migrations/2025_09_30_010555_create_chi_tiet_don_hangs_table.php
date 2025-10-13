<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->id('ChiTietID'); // đặt tên khóa chính rõ ràng
            $table->unsignedBigInteger('DonHangID');
            $table->foreign('DonHangID')
                  ->references('DonHangID')
                  ->on('don_hangs')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('SanPhamID');
            $table->foreign('SanPhamID')
                  ->references('SanPhamID')
                  ->on('san_phams')
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
