<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
  <div class="container">
    <div class="col-md-12">
      <p>quý khách vui lòng không trả lời vào mail này</p>
      <div class="row">
        <div class="col-md-6">
          <h4>Ta Cafe(Nhóm 12)</h4>
        </div>
        <div class="col-md-6 logo">
          <p>Chào bạn <strong>{{$shipping_array['customer_name']}}</strong> </p>
        </div>
        <div class="col-md-6 logo">
          <p>Bạn đã mua hàng online trên web của TA cafe(Nhóm 12)</p>
          <h4>Thông tin đơn hàng</h4>
          <p>Mã đơn hàng : <Strong>{{$code['order_code']}}</Strong></p>
          <p>Mã khuyến mãi áp dụng : <Strong>{{$code['coupon_code']}}</Strong></p>
          <p>Dịch vụ : <Strong>Đặt hàng trực tuyến</Strong></p>
          <h4>Thông tin người nhận</h4>
          <p>Email: {{$shipping_array['shipping_email']}}</p>
          <p>Họ và tên người nhận: {{$shipping_array['shipping_name']}}</p>
          <p>Địa chỉ: {{$shipping_array['shipping_address']}}</p>
          <p>Số điện thoại: {{$shipping_array['shipping_phone']}}</p>
          <p>Chú thích đơn hàng: {{$shipping_array['shipping_notes']}}</p>
          <p>Hình thức thanh toán: <strong>
              @if($shipping_array['shipping_method'] == '0'])
              Chuyển khoản
              @else
              Trả tiền mặt
              @endif
            </strong></p>
          <h4>Sản phẩm đã đặt</h4>
          <table>
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th>Giá tiền</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              @php
              $sub_total = 0;
              $total = 0;
              @endphp
              @foreach ($cart_array as $cart)
              @php
              $sub_total = $cart['product_qty']*$cart['product_price'];
              $total = $sub_total;
              @endphp
              <tr>
                <td>{{$cart['product_name']}}</td>
                <td>{{number_format($cart['product_price'],0,',','.')}}vnđ</td>
                <td>{{$cart['product_qty']}}</td>
                <td>{{number_format($sub_total,0,',','.')}}</td>
              </tr>
              @endforeach
              <tr>
                <td colspan="4" class="text-right">Tổng tiền thanh toán: {{number_format($sub_total,0,',','.')}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>