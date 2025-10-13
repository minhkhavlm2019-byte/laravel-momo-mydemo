<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('nguoi_dungs', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('HoTen', 100);
            $table->string('Email', 150)->unique();
            $table->string('MatKhau', 255);
            $table->string('maxacthuc', 10)->nullable();           // Mã OTP
            $table->timestamp('maxacthuchethan')->nullable();      // Hạn OTP
            $table->string('SoDienThoai', 15)->nullable();
            $table->string('DiaChi', 255)->nullable();
            $table->enum('VaiTro', ['Admin', 'KhachHang'])->default('KhachHang');
            $table->timestamp('NgayDangKy')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('nguoi_dungs');
    }
};
