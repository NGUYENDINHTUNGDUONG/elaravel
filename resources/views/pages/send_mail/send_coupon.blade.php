<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gửi Mã khuyến mãi cho khách vip</title>
</head>

<body>
  <h1>Mã khuyến mãi từ TA Cafe(Nhóm 12)</h1>
  <div class="container">
    <h2 class="note"><b><i>
          <?php
          if ($coupon['coupon_condition'] == 1) {
            echo "Giảm {$coupon['coupon_number']}%";
          } else {
            echo "Giảm {$coupon['coupon_number']}đ";
          }
          ?>

        </i></b></h2>
    <p class="code">Sử dụng code sau
    <h2>{{$coupon['coupon_code']}}</h2> chỉ với {{$coupon['coupon_time']}} mã</p>
    <p class="expire">Ngày bắt đầu : {{$coupon['start_date']}}/ Ngày hết hạn: {{$coupon['end_date']}}</p>
  </div>
</body>

</html>