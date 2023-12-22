<div class="aa-sidebar-widget">
  <h3>Sản phẩm bán chạy</h3>
  <div class="aa-recently-views">
    <ul>
    <?php
      // ----------- Thông tin API -----------
          $url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product/bestSellingProducts';
          $postData = array(
            'limit'=>10
          );
          $phuongthuc="GET";

      // ----------- Start get data api -----------
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $phuongthuc);
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
          $sanpham = json_decode($response);

      // ----------- End get data api -----------
    ?>
    @foreach ($sanpham as $item)
      <li>
        @if (isset($item->product_image[0]))
          <a  href="{!! url('san-pham',$item->product_id) !!}" class="aa-cartbox-img"><img alt="img" src= {!! $item->product_image[0] !!}></a>
        @else
            <a  href="{!! url('san-pham',$item->product_id) !!}" class="aa-cartbox-img"><img alt="img" src= 'https://bizweb.dktcdn.net/100/332/013/themes/685588/assets/no-product.jpg?1675674448471'></a>
        @endif
        
        <div class="aa-cartbox-info">
          <h3 style="font: 20px arial, sans-serif; margin-top: 0px;"><a  href="{!! url('san-pham',$item->product_id) !!}" style="font-size: 15px;">{!! $item->product_name !!}</a></h3>
          <p style="color:rgb(230, 0, 0); font:20px arial;">{!! number_format("$item->price_promote",0,",",".") !!} vnđ</p>
        </div>                    
      </li>
    @endforeach                                     
    </ul>
  </div>                            
</div>