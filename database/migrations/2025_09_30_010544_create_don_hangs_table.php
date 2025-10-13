<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id('DonHangID');

            // 🔹 Khóa ngoại tới bảng nguoi_dungs
            $table->unsignedBigInteger('UserID');
            $table->foreign('UserID')
                  ->references('UserID')
                  ->on('nguoi_dungs')
                  ->onDelete('cascade');

            $table->timestamp('NgayDat')->useCurrent();
            $table->decimal('TongTien', 12, 2)->default(0);
            $table->string('PhuongThucThanhToan', 50)->nullable();
            $table->string('TrangThai', 50)->default('Chờ xử lý');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('don_hangs');
    }
};
