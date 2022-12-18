@if ($slot == 'dang_cho_nhan_hang')
<span class="order-status green">Chờ xác nhận</span>
@elseif ($slot == 'da_nhan_hang')
<span class="order-status green">Đã nhận hàng</span>
@elseif ($slot == 'dang_giao_hang')
<span class="order-status yellow">Đang giao hàng</span>
@elseif ($slot == 'da_giao_hang' || $slot == 'hoan_thanh')
<span class="order-status yellow">Đã giao hàng</span>
@elseif ($slot == 'da_huy')
<span class="order-status warning">Đã hủy</span>
@endif