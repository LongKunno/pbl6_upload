<div class="navbar-collapse collapse">
  <!-- Left nav -->
    <ul class="nav navbar-nav">
      <li><a href="{!! url('/') !!}" style="font: 18px tahoma, sans-serif;">Trang chủ</a></li>
      <?php 
        function send_data_no_access_token($postData,$url,$phuongthuc){
            $user_id = request()->cookie('user_id');
            $postData = json_encode($postData);
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
            return json_decode($response);
        }
        $api_url = 'https://pbl6shopfashion-production.up.railway.app/api/category/home';
        $postData = array();
        $data = send_data_no_access_token($postData,$api_url,"GET");
       ?>
      @foreach ($data as $menu_1)
      <li><a href="{!! url('nhom-san-pham',$menu_1->categoryId) !!}" style="font: 18px tahoma, sans-serif;">{!! $menu_1->name !!}</a>
        <?php 
            $loaisp = $menu_1->brands;
         ?>
        <ul class="dropdown-menu">
        @foreach ($loaisp as $menu_2)
           <li><a href="{!! url('loai-san-pham',[$menu_1->categoryId,$menu_2->nhom_id]) !!}" style="font: 18px tahoma, sans-serif;">{!! $menu_2->nhom_ten !!}</a></li>             
        @endforeach                             
        </ul>
      </li>
      @endforeach
      <li><a href="{!! url('khuyen-mai') !!}" style="font: 18px tahoma, sans-serif;">Khuyến mãi</a></li>
      <li><a href="{!! url('thong-tin') !!}" style="font: 18px tahoma, sans-serif;">Thông tin Giày</a></li>            
      <li><a href="{!! url('tuyen-dung') !!}" style="font: 18px tahoma, sans-serif;">Tuyển dụng</a></li>
      <li><a href="{!! url('lien-he') !!}" style="font: 18px tahoma, sans-serif;">Liên hệ</a></li>
    </ul>
  </div>