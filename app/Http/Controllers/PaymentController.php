<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DonHang;

class PaymentController extends Controller
{
    
    public function checkout($DonHangID)
    {
        $donhang = DonHang::find($DonHangID);
        if (!$donhang) {
            return redirect()->route('donhang.index')
                ->with('error', 'Không tìm thấy đơn hàng để thanh toán!');
        }

        return view('donhang.payment.checkout', compact('donhang'));
    }
    public function cod(Request $request)
    {
        $donhang = DonHang::findOrFail($request->DonHangID);
        $donhang->update([
            'TrangThai' => 'Chờ giao hàng',
            'PhuongThucThanhToan' => 'COD'
        ]);

        return view('donhang.payment.success', ['method' => 'COD', 'donhang' => $donhang]);
    }
    /**
     * Thanh toán qua MoMo
     */
    public function momo(Request $request)
{
    // 🔹 1. Lấy thông tin đơn hàng từ DB
    $donHangID = $request->input('DonHangID');
    $donhang = DonHang::findOrFail($donHangID);

    // 🔹 2. Cấu hình endpoint và khóa sandbox
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    $partnerCode = "MOMOBKUN20180529";
    $accessKey   = "klm05TvNBzhg7h7j";
    $secretKey   = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

    // 🔹 3. Thông tin thanh toán
    $orderId     = (string) $donhang->DonHangID;  // ID đơn hàng thật trong DB
    $amount      = (int) $donhang->TongTien;      // Tổng tiền đơn hàng
    $orderInfo   = "Thanh toán đơn hàng #" . $orderId . " qua MoMo";
    $redirectUrl = route('payment.return');       // Trang trả về sau khi thanh toán
    $ipnUrl      = route('payment.notify');       // Server nhận kết quả IPN
    $extraData   = "";                            // Có thể bỏ trống
    $requestId   = time() . "";
    $requestType = "captureWallet";               // captureWallet: thanh toán ví MoMo

    // 🔹 4. Tạo chuỗi ký hash
    $rawHash = "accessKey=" . $accessKey
             . "&amount=" . $amount
             . "&extraData=" . $extraData
             . "&ipnUrl=" . $ipnUrl
             . "&orderId=" . $orderId
             . "&orderInfo=" . $orderInfo
             . "&partnerCode=" . $partnerCode
             . "&redirectUrl=" . $redirectUrl
             . "&requestId=" . $requestId
             . "&requestType=" . $requestType;

    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    // 🔹 5. Dữ liệu gửi sang MoMo
    $data = [
        'partnerCode' => $partnerCode,
        'partnerName' => 'MyShop',
        'storeId'     => 'MomoTestStore',
        'requestId'   => $requestId,
        'amount'      => $amount,
        'orderId'     => $orderId,
        'orderInfo'   => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl'      => $ipnUrl,
        'lang'        => 'vi',
        'extraData'   => $extraData,
        'requestType' => $requestType,
        'signature'   => $signature
    ];

    // 🔹 6. Gửi request POST đến MoMo
    $response = Http::post($endpoint, $data)->json();

    // 🔹 7. Nếu tạo link thành công → cập nhật trạng thái và redirect
    if (!empty($response['payUrl'])) {
        $donhang->update([
            'TrangThai' => 'Đang thanh toán',
            'PhuongThucThanhToan' => 'MoMo',
        ]);

        return redirect()->away($response['payUrl']);
    }

    // 🔹 8. Nếu thất bại → báo lỗi
    return back()->with('error', 'Không tạo được giao dịch MoMo!');
}


    
    /**
     * MoMo return URL
     * 
     */
    public function return(Request $request)
    {
        $orderId = $request->orderId;
        $donhang = DonHang::find($orderId);

        if ($request->resultCode == 0) {
            $donhang?->update(['TrangThai' => 'Đã thanh toán']);
            return view('payment.success', ['method' => 'MoMo', 'donhang' => $donhang]);
        }

        return view('payment.fail', [
            'donhang' => $donhang,
            'message' => 'Thanh toán thất bại. Vui lòng thử lại.'
        ]);
    }

    public function notify(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }
}
