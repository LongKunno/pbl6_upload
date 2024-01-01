<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
    <title>In hóa đơn</title>
    <style>
      body{
        font-family: DejaVu Sans, sans-serif, font-size: 12px;
      }
    </style>
  </head>
  
  <body >
    <div>
      <b><span>CỬA HÀNG NO NAME</span></b><br>
      Sơn Trà - Đà Nẵng<br>
      Số điện thoại: 0919900743<br>
      Website: http://localhost/pbl6/
    </div><hr>
    <center><h2>ĐƠN ĐẶT HÀNG</h2></center>
    
    <table>
      <tr>
        <td width="120px"><strong>Khách hàng:</strong></td> <td>{!!$donhang->name!!}</td>
        <td><strong></td>
      </tr>
      <tr>
        <td width="120px"><strong>Địa chỉ:</strong></td> <td>{!!$donhang->shippingAddress!!}</td>
        <td></td>
      </tr>
      <tr>
        <td width="120px"><strong>Điện thoại:</strong></td> <td> {!!$donhang->phoneNumber!!}</td>
        <td></td>
      </tr>
      <tr>
        <td width="120px"><strong>Note:</strong></td> <td> {!!$donhang->note!!}</td>
        <td></td>
      </tr>
    </table><br><br>
    <table cellpadding="3px" style="border:thin solid;" >
      <thead>
        <tr>
          <td style="border:thin solid;" width="50px"><strong>STT</strong></td>
          <td style="border:thin solid;" width="150px"><strong>Sản phẩm</strong></td>
          <td style="border:thin solid;" width="50px"><strong>Số lượng</strong></td>
          <td style="border:thin solid;" width="50px"><strong>Size</strong></td>
          <td style="border:thin solid;" width="150px"><strong>Đơn giá</strong></td>
          <td style="border:thin solid;" width="150px"><strong>Thành tiền</strong></td>
        </tr>
      </thead>
      <tbody>
        <?php $count = 0; ?>
            @foreach ($donhang->orderItems as $val)
            <tr >
              <td style="border:thin blue solid;border-style:dashed;">{!! $count = $count + 1 !!}</td>
              <td style="border:thin blue solid;border-style:dashed;">
                <?php  
                    $url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product_detail?id='.$val->productId;
                    $postData = array();
                    $postData = json_encode($postData);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    // Thực hiện yêu cầu POST
                    $response = curl_exec($ch);
                    // Kiểm tra lỗi
                    if (curl_errno($ch)) {
                        $error = curl_error($ch);
                        dd($error);
                    }
                    // Đóng kết nối cURL
                    curl_close($ch);
                    $data_orders_product_detail = json_decode($response);
                    print_r($data_orders_product_detail->productName);
                ?>
              </td>
              <td style="border:thin blue solid;border-style:dashed;">{!! $val->quantity !!}</td>
              <td style="border:thin blue solid;border-style:dashed;">{!! $val->sizeType !!}</td>
              <td style="border:thin blue solid;border-style:dashed;">
              {!! number_format($val->unitPrice,0,",",".") !!} vnđ 
              </td>
              <td style="border:thin blue solid;border-style:dashed;" >{!! number_format($val->unitPrice*$val->quantity,0,",",".") !!} vnđ </td>
          </tr>
            @endforeach
            <tr>
              <td  width="150px" >
                    <b>Ghi chú :</b>
              </td>
              <td colspan="4">
                    {{ $donhang->note }}
                </td>
            </tr>
      </tbody>
    </table>
    <table class="sumary-table">
      <tr>
        <td width="500px">Giá trị đơn hàng</td>
        <td style="border:thin blue solid;border-style:dashed;" width="152px">{!! number_format($donhang->totalProductAmount, 0, ",", ".") !!} vnđ</td>
      </tr>
      <tr>
        <td width="500px">Số tiền phải trả</td>
        <td width="152px" style="border:thin blue solid;border-style:dashed;">{!! number_format($donhang->totalPayment, 0, ",", ".") !!} vnđ</td>
      </tr>
    </table><br>
    <table style="margin-bottom:-300px;">
      <tr>
        <td width="500px"></td>
        <td>Ngày lập: <?php echo date("d-m-Y") ?></td>
      </tr>
      <tr>
        <td width="500px" class="customer-title">   <strong>Khách hàng</strong></td>
        <td class="writer-title"><strong>Người lập phiếu</strong></td>
      </tr>
      <tr>
        <td>(Ký và ghi rõ họ tên)</td>
        <td class="writer-name"><span>(Ký và ghi rõ họ tên)</span></td>
      </tr>
    </table>
  </body>
</html>
    
