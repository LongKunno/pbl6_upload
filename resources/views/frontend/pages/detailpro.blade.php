@extends('frontend.master')
@section('content')
<?php
$hinhsanpham_url = $data->hinhsanpham_url;
$imageUrl = $hinhsanpham_url[0]->imageUrl;
$sanpham_ten = $data->sanpham_ten;
$sanpham_id = $data->sanpham_id;
$nhom_ten = $data->nhom_ten;
$nhom_id = $data->nhom_id;
$loaisanpham_ten = $data->loaisanpham_ten;
$loaisanpham_id = $data->loaisanpham_id;
$lohang_gia_ban_ra = $data->lohang_gia_ban_ra;
$sanpham_mota = $data->sanpham_mota;
$comments = $data ->comments;


  $url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product_detail?id='.$sanpham_id;
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
  $data_product_detail = json_decode($response);
  $data_product_detail_size = $data_product_detail->sizeNames;
?>
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="{!! $imageUrl !!}" alt="fashion img" style="width: 1920px; height: 300px;">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>{!! $sanpham_ten !!}</h2>
        <ol class="breadcrumb">
          <li><a href="{!! url('/') !!}">Home</a></li>
          <li><a href="{!! url('nhom-san-pham',$nhom_id) !!}">{!! $nhom_ten !!}</a></li>
          <li><a href="{!! url('loai-san-pham',$loaisanpham_id) !!}">{!! $loaisanpham_ten !!}</a></li>    
          <li class="active">{!! $sanpham_ten !!}</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->
  <!-- product category -->
<section id="aa-product-details">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <div class="aa-product-details-area">
        <div class="aa-product-details-content">
          <div class="row">
          <!-- Modal view slider -->
          <div class="col-md-5 col-sm-5 col-xs-12">
            <div class="aa-product-view-slider" >
            <a href="{!! $imageUrl !!}" class="MagicZoom" style="width: 300px;height: 400px;" id="jeans" data-options="selectorTrigger: hover; transitionEffect: false;">
            <img src="{!! $imageUrl !!}" style="width: 250px; height: 300px;"></a> 
             @foreach ($hinhsanpham_url as $hinh)
                <a data-zoom-id="jeans" href="{!! $hinh->imageUrl !!}" data-image="{!! $hinh->imageUrl !!}">
                <img src="{!! $hinh->imageUrl !!}" style="width: 45px; height: 55px;">
                </a>
              @endforeach                              
          </div>
          </div>
          <!-- Modal view content -->
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="aa-product-view-content">
            <h1>{!! $sanpham_ten !!}</h1>
            <div class="aa-price-block">
              <h3>
              Giá: 
              <span class="aa-product-price">
                <del>{!! number_format("$data->lohang_gia_ban_ra",0,",",".") !!} vnđ</del>
              </span> 
              <span class="aa-product-view-price">{!! number_format("$data->actualPrice",0,",",".") !!}vnđ</span>
              </h3>
            </div>
            
            <div class="aa-prod-quantity">
              <p class="aa-prod-category">
              Loại sản phẩm: <a href="{!! url('loai-san-pham',$loaisanpham_id) !!}">{!! $loaisanpham_ten !!}</a>
              </p>
            </div>
            <div class="aa-prod-view-bottom">
              <div style="width:16%">
                <select id="select_size" class="form-control" style="width: 70px;">
                      <?php
                      echo '<option value="">size</option>';
                        foreach ($size as $option) {
                              if (in_array($option["name"], $data_product_detail_size)) {
                                echo '<option value="' . $option["id"] . '" style="display:;">' . $option["name"] . '</option>';
                              } else {
                                echo '<option value="' . $option["id"] . '" style="display:none;">' . $option["name"] . '</option>';
                              }
                        }
                      ?>
                  </select>
              </div>
              <a id="buy-btn" class="aa-add-to-cart-btn" href="{!! url('mua-hang',[$sanpham_id,$sanpham_id]) !!}" style="background-color: #28a54b;">
                <span class="fa fa-shopping-cart" style="color: white !important;font-size: 15px;">Mua hàng</a>
            </div>
            </div>
          </div>
          <script>
            var selectedSize = $("#select_size").find(":selected").text();
            $("#buy-btn").attr("href", "{!! url('mua-hang', [$sanpham_id, $sanpham_id]) !!}" + "?size=" + selectedSize);
            $("#select_size").change(function() {
              var selectedSize = $("#select_size").find(":selected").text();
              $("#buy-btn").attr("href", "{!! url('mua-hang', [$sanpham_id, $sanpham_id]) !!}" + "?size=" + selectedSize);
            });
          </script>
          
        </div>
        <div class="aa-product-details-bottom">
              <ul class="nav nav-tabs" id="myTab2">
                <li><a href="#description" data-toggle="tab">Mô tả sản phẩm</a></li>
                <li><a href="#review" data-toggle="tab">Nhận xét</a></li>                
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane fade in active" id="description">
                  <p>{!! $sanpham_mota !!}</p>
                  
                </div>
                <div class="tab-pane fade " id="review">
                 <div class="aa-product-review-area">
                   <h4> Nhận xét</h4> 
                   <ul class="aa-review-nav">
                    @if ($comments != null)
                      @foreach ($comments as $item)
                        <li>
                          <div class="media">
                            <div class="media-left">
                              <a href="#">
                                <img src="{!! url('public/images/avatar.jpg') !!}" alt="fashion img" style="width: 50px; height: 50px;" >
                              </a>
                            </div>
                            <div class="media-body">
                              <h4 class="media-heading"><strong>{!! $item->name !!}</strong> - <span>{!! date("d-m-Y",strtotime($item->createAt)) !!}</span></h4>
                              <p>{!! $item->content !!}</p>
                            </div>
                          </div>
                        </li>
                      @endforeach
                    @endif
                   </ul>


                   <h4>Thêm bình luận</h4>
                   <!-- review form -->
                   <form action="{!! url('binh-luan') !!}"  class="aa-review-form" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                    <input type="hidden" name="txtID" value="{!! $sanpham_id !!}" />
                      <div class="form-group">
                        <label for="message">Nội dung<span class="required">*</span></label>
                        <textarea class="form-control" name="txtContent" rows="3" id="message" required="required"></textarea>
                        <div>
                            {!! $errors->first('txtContent') !!}
                        </div>
                      </div>
                      <button type="submit" class="btn btn-default aa-review-submit">Gửi</button>
                   </form>
                 </div>
                </div>            
              </div>
            </div>
            <!-- Related product -->
            <!-- <div class="aa-product-related-item">
              <h3>Related Products</h3>
              <ul class="aa-product-catg aa-related-item-slider">
                                                                                  
              </ul>
            </div> -->
          </div>
         </div>   
    </div>
        </div>
        </div>
  </section>
  <!-- / product category -->
  <!-- Footer -->
@include('frontend.blocks.footer')
<!-- / Footer -->
@stop