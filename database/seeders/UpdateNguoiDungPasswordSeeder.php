<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;

class UpdateNguoiDungPasswordSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy tất cả người dùng trong bảng
        $users = NguoiDung::all();

        foreach ($users as $user) {
            $user->MatKhau = Hash::make('123456'); // hash mật khẩu mới
            $user->save();
        }

        echo "✅ Đã cập nhật lại toàn bộ mật khẩu thành công.\n";
    }
}
