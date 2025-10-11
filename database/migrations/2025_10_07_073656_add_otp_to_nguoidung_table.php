<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->string('MaXacThuc', 10)->nullable()->after('MatKhau')
                  ->comment('Mã OTP xác thực');
            $table->timestamp('MaXacThucHetHan')->nullable()->after('MaXacThuc')
                  ->comment('Thời gian hết hạn của mã OTP');
        });
    }

    public function down(): void
    {
        Schema::table('nguoi_dungs', function (Blueprint $table) {
            $table->dropColumn(['MaXacThuc', 'MaXacThucHetHan']);
        });
    }
};

