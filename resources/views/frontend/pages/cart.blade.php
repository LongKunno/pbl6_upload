@extends('frontend.master')
@section('content')
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="{!! url('public/images/cartpannel.jpg') !!}" alt="fashion img" style="width: 1920px; height: 300px;" >
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Giỏ hàng</h2>
        <ol class="breadcrumb">
          <li><a href="{!! url('/') !!}">Trang chủ</a></li>         
          <li class="active">Giỏ hàng</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / product category -->



 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             <form action="">
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th style="width:70px;">Size</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                    <form action="" method="POST" accept-charset="utf-8">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                    @foreach ($data as $item)
                      <?php 
                          $url = 'https://pbl6shopfashion-production.up.railway.app/api/product/detail/'.$item->productId;
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
                          $sanpham = json_decode($response);
                          
                       ?>
                      <tr id="{!! $item->id !!}">
                        <td><input type="checkbox" id="checkbox_cart_items" name="checkbox_cart_items" value="{!! $item->id !!}" checked></td>
                        <td><a class="updatecart edit" id={!! $item->id !!} value={!! $item->id !!} href='#'><fa class=" fa fa-edit"></fa></a></td>
                        <td><a class="remove" href='{!! URL::route("xoasanpham", ["id" => $item->id] ) !!}'><fa class="fa fa-close"></fa></a></td>
                        <td><a href="{!! url('san-pham',$sanpham->sanpham_id) !!}"><img src="{!! $sanpham->hinhsanpham_url[0]->imageUrl !!}"  style="width: 45px; height: 50px;"></a></td>
                        <td><a class="aa-cart-title" href="{!! url('san-pham',$sanpham->sanpham_id) !!}">{!!  $sanpham->sanpham_ten !!}</a></td>
                        <?php 
                          $url = 'https://pbl6shopfashion-production.up.railway.app/api/product/product_detail?id='.$sanpham->sanpham_id;
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
                        <td>
                          <div>
                            <select id="select_size" data={!! $item->id !!} class="form-control" style="width: 70px;">
                                <?php
                                  foreach ($size as $option) {
                                      if ($option["name"] == $item->size) {
                                        if (in_array($option["name"], $data_product_detail_size)) {
                                          echo '<option value="' . $option["id"] . '" selected style="display:;">' . $option["name"] . '</option>';
                                        } else {
                                          echo '<option value="' . $option["id"] . '" selected style="display:none;">' . $option["name"] . '</option>';
                                        }
                                      } else {
                                        if (in_array($option["name"], $data_product_detail_size)) {
                                          echo '<option value="' . $option["id"] . '" style="display:;">' . $option["name"] . '</option>';
                                        } else {
                                          echo '<option value="' . $option["id"] . '" style="display:none;">' . $option["name"] . '</option>';
                                        }
                                      }
                                  }
                                ?>
                            </select>
                          </div>

                        </td>
                        <td>{!! number_format("$data_product_detail->price_promote",0,",",".") !!}vnđ</td>
                        <td><input class="qty aa-cart-quantity" id="quantity" data={!! $item->id !!} name="quantity" type="number" value="{!!  $item->quantity !!}" min="0"></td>
                        <td>{!! number_format($data_product_detail->price_promote*$item->quantity,0,",",".") !!}vnđ</td>
                        @php
                            $total += $data_product_detail->price_promote*$item->quantity;
                        @endphp
                      </tr>
                    @endforeach
                    </form>
                      </tbody>
                      
                  </table>
                </div>
             </form>
             <!-- Cart Total view -->
             <div class="cart-view-total">
               <!-- <h4>Tổng tiền</h4> -->
               {{-- <table class="aa-totals-table">
                 <tbody>
                   <tr>
                     <th>Tổng tiền</th>
                     <td> {!! number_format("$total",0,",",".") !!}vnđ</td>
                   </tr>
                 </tbody>
               </table> --}}
               @if (request()->hasCookie('access_token'))
                  <a href="{!! url('/') !!}" class="aa-cart-view-btn"> Mua tiếp</a>
                  <a href="{!! URL::route('getThanhtoan') !!}" id="cart_thanhtoan" class="aa-cart-view-btn">Thanh Toán</a>
                  
               @else
                  <a href="{!! url('/') !!}" class="aa-cart-view-btn">Mua tiếp</a>
                  <a href="{!! url('login') !!}" class="aa-cart-view-btn">Thanh Toán</a>
               @endif
               
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->
<!-- Support section -->
{{-- @include('frontend.blocks.trans') --}}
<section id="aa-support" style="margin-top: 70px;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="aa-support-area">
          <!-- single support -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="aa-support-single">
              <span class="fa fa-truck"></span>
              <h4>GIAO HÀNG MIỄN PHÍ</h4>

              <!-- <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P> -->
            </div>
          </div>
          <!-- single support -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="aa-support-single">
              <span class="fa fa-clock-o"></span>
              <h4>THANH TOÁN KHI NHẬN HÀNG</h4>
              <!-- <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P> -->
            </div>
          </div>
          <!-- single support -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="aa-support-single">
              <span class="fa fa-phone"></span>
              <h4>HỖ TRỢ 24/7</h4>
              <!-- <P>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam, nobis.</P> -->
            </div>
          </div>
          
          <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
          <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>




        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function(){
    $("#cart_thanhtoan").on("click",function(e){
      e.preventDefault();
      var selectedCheckboxValues = [];
      $('input[name="checkbox_cart_items"]:checked').each(function() {
        selectedCheckboxValues.push($(this).val());
      });
      document.cookie = "selectedCheckboxValues=" + JSON.stringify(selectedCheckboxValues) + ";";
      window.location.href = "{!! URL::route('getThanhtoan') !!}";
    })

    $(".updatecart").on("click",function(e){
      e.preventDefault();
      var data_update_cart = {};
      data_update_cart['id'] = $("#"+$(this).attr("value")+" #checkbox_cart_items").val()
      data_update_cart['size'] =  $("#"+$(this).attr("value")+" #select_size").val()
      data_update_cart['quantity'] =  $("#"+$(this).attr("value")+" #quantity").val()
      document.cookie = "data_update_cart=" + JSON.stringify(data_update_cart) + ";";
      window.location.href = "{!! URL::route('capnhat', ['id' => 'id' ]) !!}";
    })

    $("#select_size").on("change",function(e){
      e.preventDefault();
      var data_update_cart = {};
      data_update_cart['id'] = $("#"+$(this).attr("data")+" #checkbox_cart_items").val()
      data_update_cart['size'] =  $("#"+$(this).attr("data")+" #select_size").val()
      data_update_cart['quantity'] =  $("#"+$(this).attr("data")+" #quantity").val()
      document.cookie = "data_update_cart=" + JSON.stringify(data_update_cart) + ";";
      window.location.href = "{!! URL::route('capnhat', ['id' => 'id' ]) !!}";
    })

    $("#quantity").on("change",function(e){
      e.preventDefault();
      var data_update_cart = {};
      data_update_cart['id'] = $("#"+$(this).attr("data")+" #checkbox_cart_items").val()
      data_update_cart['size'] =  $("#"+$(this).attr("data")+" #select_size").val()
      data_update_cart['quantity'] =  $("#"+$(this).attr("data")+" #quantity").val()
      document.cookie = "data_update_cart=" + JSON.stringify(data_update_cart) + ";";
      window.location.href = "{!! URL::route('capnhat', ['id' => 'id' ]) !!}";
    })

  })
</script>
<!-- / Support section -->

 <!-- Footer -->
@include('frontend.blocks.footer')
<!-- / Footer -->
@stop