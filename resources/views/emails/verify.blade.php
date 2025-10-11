@component('mail::message')
# Mã xác thực của bạn

Xin chào,  
Mã xác thực để kích hoạt tài khoản của bạn là:

@component('mail::panel')
<h2>{{ $code }}</h2>
@endcomponent

Mã này sẽ hết hạn sau 10 phút.  
Cảm ơn bạn đã đăng ký tại **MyStore**!

@endcomponent
