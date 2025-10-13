<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('thuong_hieus', function (Blueprint $table) {
            $table->id('ThuongHieuID');
            $table->string('TenThuongHieu', 100)->unique();
            $table->string('QuocGia', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('thuong_hieus');
    }
};

