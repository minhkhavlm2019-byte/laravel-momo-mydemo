@component('mail::message')
# Mã xác thực của bạn

Xin chào!  
Mã xác thực (OTP) của bạn là:

@component('mail::panel')
<h2 style="text-align:center; font-size:28px; color:#d63384;">{{ $otp }}</h2>
@endcomponent

Mã này có hiệu lực trong **10 phút**.  
Nếu bạn không thực hiện hành động này, vui lòng bỏ qua email.

Trân trọng,  
**Hệ thống MyStore**
@endcomponent
