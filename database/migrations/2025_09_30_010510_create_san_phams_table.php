<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id('SanPhamID');
            $table->string('TenSanPham', 150);
            $table->text('MoTa')->nullable();
            $table->decimal('Gia', 10, 2);
            $table->integer('SoLuongTon')->default(0);

            // 🔹 Khóa ngoại đến bảng thuong_hieus
            $table->unsignedBigInteger('ThuongHieuID');
            $table->foreign('ThuongHieuID')
                  ->references('ThuongHieuID')
                  ->on('thuong_hieus')
                  ->onDelete('cascade');

            // 🔹 Khóa ngoại đến bảng loai_san_phams
            $table->unsignedBigInteger('LoaiID');
            $table->foreign('LoaiID')
                  ->references('LoaiID')
                  ->on('loai_san_phams')
                  ->onDelete('cascade');

            $table->string('HinhAnh')->nullable();
            $table->date('NgayNhap')->nullable();
            $table->boolean('TrangThai')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('san_phams');
    }
};
