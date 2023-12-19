<div class="navbar-collapse collapse">
  <!-- Left nav -->
    <ul class="nav navbar-nav">
      <li><a href="{!! url('/') !!}" style="font: 18px tahoma, sans-serif;">Trang chủ</a></li>
      <?php 
        $api_url = 'http://192.168.55.111:8080/api/category/home';
        $response = file_get_contents($api_url);
        $data = json_decode($response);
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