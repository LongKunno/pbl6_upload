@extends('frontend.master')
@section('content')
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="{!! url('public/images/cartpannel.jpg') !!}" alt="fashion img" style="width: 1920px; height: 300px;" >
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Thanh toán</h2>
        <ol class="breadcrumb">
          <li><a href="{!! url('/') !!}">Trang chủ</a></li>         
          <li class="active">Thanh toán</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / product category -->
 <!-- Cart view section -->
 <section id="checkout">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="checkout-area">
          <form action="{!! route('getThanhtoan') !!}" method="POST">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
            <div class="row">
                  <div class="panel-body">
                       
                    <input type="submit" value="Xác nhận" class="aa-browse-btn">
                  </div>
              <div class="col-md-8">
                <div class="checkout-left">
                  <div class="panel-group" id="accordion">
                    <!-- Billing Details -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Thông tin thanh toán
                          </a>
                        </h4>
                      </div>
                      <input type="hidden" name="" value="{!! $khachhang->id !!}" />
                      <input type="hidden" name="txtKHID" value="{!! $khachhang->id !!}" />
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" name="txtKHName" value="{{ $khachhang->name }}" placeholder="Họ và tên" style="background-color: #e8f4ff;" readonly>
                              </div>                             
                            </div>
                          </div>
                          <div class="row">
                            {{-- Chọn quận huyện --}}
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <div>
                                <select id="select_thanhtoan" name="select_thanhtoan" class="form-control" >
                                  <option value=""> -- Chọn phương thức thanh toán -- </option>
                                  <option value="VNPAY"> thành toán qua Vn Pay </option>
                                  <option value="CASH"> Thanh toán khi nhận hàng </option>
                                </select>
                              </div>       
                              </div>                             
                            </div>
                            <div class="col-md-6">
                              <div class="aa-checkout-single-bill">
                                <input type="tel" name="txtKHPhone" value="{{ $khachhang->phoneNumber }}"  placeholder="Số điện thoại"style="
    background-color: #e8f4ff;
" readonly>
                              </div>
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <select id="select_giamgiasanpham" name="select_giamgiasanpham" class="form-control" >
                                  <option value=""> -- Chọn mã giảm giá -- </option>
                                  <?php 
                                      foreach ($list_giamgia as $option) {
                                        echo '<option '.'data-maxDiscountValue="'. $option["maxDiscountValue"] .'" data-discountType="'. $option["discountType"] .'" data-value="'. $option["discountValue"] .'" value="' . $option["id"] . '" >' . $option["name"] . '</option>';
                                      }
                                    ?>
                                </select>
                              </div>                             
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <select id="select_giamgiavanchuyen" name="select_giamgiavanchuyen" class="form-control" >
                                  <option value=""> -- Chọn mã Freeship -- </option>
                                  <?php 
                                      foreach ($list_freeship as $option) {
                                        echo '<option '.'data-maxDiscountValue="'. $option["maxDiscountValue"] .'" data-discountType="'. $option["discountType"] .'" data-value="'. $option["discountValue"] .'" value="' . $option["id"] . '" >' . $option["name"] . '</option>';
                                      }
                                    ?>
                                </select>
                              </div>                             
                            </div>
                          </div>                                              
                        </div>
                      </div>
                    </div>
                    <!-- Shipping Address -->
                    <div class="panel panel-default aa-checkout-billaddress">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            Thông tin nhận hàng
                          </a>
                        </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                          {{-- Chọn thông tin mặc định --}}
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <select id="select_thongtinnhanhang" name="select_thongtinnhanhang" class="form-control" >
                                  <option value="new">Nhập thông tin nhận hàng mới</option>
                                    <?php 
                                      foreach ($list_thongtinnhanhang as $option) {
                                        echo '<option value="' . $option["id"] . '" >' . $option["name"] . '</option>';
                                      }
                                    ?>
                                </select>
                              </div>       
                              </div>                             
                            </div>
                         <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" name="txtNNName" id="txtNNName"  placeholder="Họ và tên*">
                                <div>
                                    {!! $errors->first('txtNNName') !!}
                                </div>
                              </div>                             
                            </div>
                          </div> 
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="tel" name="txtNNPhone"  id="txtNNPhone" placeholder="Số điện thoại*">
                                <div>
                                    {!! $errors->first('txtNNPhone') !!}
                                </div>
                              </div>
                            </div>
                          </div> 
                          {{-- Chọn thành phố --}}
                          <div class="row">
                            <div class="col-md-4">
                              <div class="aa-checkout-single-bill">
                                <div >
                                <select id="select_thanhpho" name="select_thanhpho" class="form-control" >
                                    <?php 
                                      Select_Function($list_thanhpho); 
                                    ?>
                                </select>
                              </div>       
                              </div>                             
                            </div>
                            {{-- Chọn quận huyện --}}
                            <div class="col-md-4">
                              <div class="aa-checkout-single-bill">
                                <div>
                                <select id="select_quan" name="select_quan" class="form-control" >
                                    <?php 
                                      Select_Function($list_quan); 
                                    ?>
                                </select>
                              </div>       
                              </div>                             
                            </div>
                            {{-- Chọn phường xã --}}
                            <div class="col-md-4">
                              <div class="aa-checkout-single-bill">
                                <div >
                                <select id="select_phuong" name="select_phuong" class="form-control" >
                                    <?php 
                                      Select_Function($list_phuong); 
                                    ?>
                                </select>
                              </div>       
                              </div>                             
                            </div>                            
                          </div>
                          {{-- Xử lý sự kiện chọn địa chỉ --}}
                            <script>
                              $(document).ready(function() {
                                  $('#select_thanhpho').change(function() {
                                    var selectedOption = $(this).find('option:selected');
                                    var dataValue = selectedOption.text();
                                    $("#tinh_tp").val(dataValue);
                                    $('#loading').show();
                                    $("#select_quan").html("");
                                      var selectedValue = $(this).val();
                                      $.ajax({
                                          method: "GET",
                                          url: 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district',
                                          headers: {
                                            'Token': 'c61b8d62-a18d-11ee-a6e6-e60958111f48',
                                            'Content-Type': 'application/json'
                                          },
                                          data: {
                                            "province_id": selectedValue
                                          },
                                          success: function(response){
                                              $('#loading').hide();
                                              var data = response.data
                                              for(let i=0;i<data.length;i++){
                                                $("#select_quan").append($('<option>').val(data[i].DistrictID).text(data[i].DistrictName));
                                              }
                                              
                                          },
                                          error: function(e){
                                              $('#loading').hide();
                                              console.log(e);
                                              alert(e.responseText);
                                          }
                                      })     
                                  });
                                  $('#select_quan').change(function() {
                                    var selectedOption = $(this).find('option:selected');
                                    var dataValue = selectedOption.text();
                                    $("#quan_huyen").val(dataValue);
                                    $('#loading').show();
                                    $("#select_phuong").html("");
                                      var selectedValue = $(this).val();
                                      $.ajax({
                                          method: "GET",
                                          url: 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward',
                                          headers: {
                                            'Token': 'c61b8d62-a18d-11ee-a6e6-e60958111f48',
                                            'Content-Type': 'application/json'
                                          },
                                          data: {
                                            "district_id": selectedValue
                                          },
                                          success: function(response){
                                              $('#loading').hide();
                                              var data = response.data
                                              for(let i=0;i<data.length;i++){
                                                $("#select_phuong").append($('<option>').val(data[i].WardCode).text(data[i].WardName));
                                              }
                                              
                                          },
                                          error: function(e){
                                              $('#loading').hide();
                                              console.log(e);
                                              alert(e.responseText);
                                          }
                                      })     
                                  });
                                  $('#select_phuong').change(function() {
                                    var selectedOption = $(this).find('option:selected');
                                    var dataValue = selectedOption.text();
                                    $("#xa_phuong").val(dataValue);
                                    
                                    if($("#select_phuong").val()!=""){
                                      $('#loading').show();
                                      var selectedValue = $(this).val();
                                      $.ajax({
                                          method: "GET",
                                          url: 'https://pbl6shopfashion-production.up.railway.app/api/orders/fee-ship?districtId='+$("#select_quan").val()+'&wardCode='+$("#select_phuong").val(),
                                          success: function(response){
                                              $('#loading').hide();
                                              var data = response.data
                                              $("#phi_ship").val(data.feeShip);
                                              reload_total_price()
                                              
                                          },
                                          error: function(e){
                                              $('#loading').hide();
                                              console.log(e);
                                              alert(e.responseText);
                                          }
                                      })     
                                    }
                                  });
                                  $('#select_giamgiasanpham').change(function() {
                                    var selectedOption = $(this).find('option:selected');
                                    var dataValue = selectedOption.attr('data-value');
                                    var discountType = selectedOption.attr('data-discountType');
                                    var maxDiscountValue = selectedOption.attr('data-maxDiscountValue');
                                    if(discountType=="PERCENTAGE"){
                                      $("#kieu_giam_gia_sp").val("%");
                                      $("#giam_gia_sp_show").val(dataValue+"%");
                                    }else{
                                      $("#kieu_giam_gia_sp").val("vnd");
                                      $("#giam_gia_sp_show").val(dataValue+" vnd");
                                    }
                                    $("#giam_gia_sp").val(dataValue);
                                     $("#maxDiscountValue_sp").val(maxDiscountValue)
                                     reload_total_price()
                                  });
                                  $('#select_giamgiavanchuyen').change(function() {
                                    var selectedOption = $(this).find('option:selected');
                                    var dataValue = selectedOption.attr('data-value');
                                    var discountType = selectedOption.attr('data-discountType');
                                    var maxDiscountValue = selectedOption.attr('data-maxDiscountValue');
                                    if(discountType=="PERCENTAGE"){
                                      $("#kieu_giam_gia_vc").val("%");
                                      $("#giam_gia_vc_show").val(dataValue+"%");
                                    }else{
                                      $("#kieu_giam_gia_vc").val("vnd");
                                      $("#giam_gia_vc_show").val(dataValue+" vnd");
                                    }
                                     $("#giam_gia_vc").val(dataValue);
                                     $("#maxDiscountValue_vc").val(maxDiscountValue)
                                     reload_total_price()
                                  });
                                  function reload_total_price(){
                                    var total=0;
                                    $(".gia_sp").each(function(){
                                      total +=  parseInt($(this).val());
                                    })
                                    if($("#giam_gia_sp").val()!=""){
                                      if($("#kieu_giam_gia_sp").val()=="vnd"){
                                        var giam_gia_sp = parseInt($("#giam_gia_sp").val());
                                        var giam_gia_sp_last = giam_gia_sp;
                                        total -= giam_gia_sp_last;
                                      }else{
                                        var giam_gia_sp = parseInt($("#giam_gia_sp").val());
                                        var giam_gia_sp_last = ((total * giam_gia_sp)/100);
                                        if(giam_gia_sp_last > $("#maxDiscountValue_sp").val()){
                                          giam_gia_sp_last = $("#maxDiscountValue_sp").val()
                                        }
                                        total = total - giam_gia_sp_last;
                                      }
                                    }
                                    if($("#phi_ship").val()!=""){
                                      var phi_ship = parseInt($("#phi_ship").val());
                                      total += phi_ship;
                                      if($("#giam_gia_sp").val()!=""){
                                        if($("#kieu_giam_gia_vc").val()=="vnd"){
                                          var giam_gia_vc = parseInt($("#giam_gia_vc").val());
                                          var giam_gia_vc_last = giam_gia_vc;
                                          total -= giam_gia_vc_last;
                                        }else{
                                          var giam_gia_vc = parseInt($("#giam_gia_vc").val());
                                          var giam_gia_vc_last = ((total * giam_gia_vc)/100);
                                          if(giam_gia_vc_last > $("#maxDiscountValue_vc").val()){
                                            giam_gia_vc_last = $("#maxDiscountValue_vc").val()
                                          }
                                          total = total - giam_gia_vc_last;
                                        }
                                    }
                                    }
                                    $("#tong_cong").val(total);
                                    $("#totalPayment").val(total);
                                    
                                  }
                                  $("#select_thongtinnhanhang").on("change",function(){
                                    if($(this).val()!='new'){
                                      $.ajax({
                                          method: "GET",
                                           headers: {
                                                  "Authorization": "Bearer " + "{!! request()->cookie('access_token') !!}",
                                                },
                                          url: "{!! 'https://pbl6shopfashion-production.up.railway.app/api/users/'.$user_id.'/addresses/' !!}" + $(this).val(),
                                          success: function(response_data){
                                            console.log(response_data)
                                            $("#shippingAddress").val(response_data.street +" - "+ response_data.address).hide();
                                            $("#txtNNName").val(response_data.name).hide();
                                            $("#txtNNPhone").val(response_data.phoneNumber).hide();
                                            $("#select_thanhpho").val("").hide();
                                            $("#select_quan").html("<option value='"+response_data.districtId+"' selected></option>").hide()
                                            $("#select_phuong").html("<option value='"+response_data.wardCode+"' selected></option>").hide()
                                            reload_total_price()
                                            var selectedOption = $("#select_phuong").find('option:selected');
                                                var dataValue = selectedOption.text();
                                                $("#xa_phuong").val(dataValue);
                                                
                                                if($("#select_phuong").val()!=""){
                                                  $('#loading').show();
                                                  var selectedValue = $("#select_phuong").val();
                                                  $.ajax({
                                                      method: "GET",
                                                      url: 'https://pbl6shopfashion-production.up.railway.app/api/orders/fee-ship?districtId='+$("#select_quan").val()+'&wardCode='+$("#select_phuong").val(),
                                                      success: function(response_fee){
                                                          $('#loading').hide();
                                                          var data = response_fee.data
                                                          $("#phi_ship").val(data.feeShip);
                                                          reload_total_price()
                                                          
                                                      },
                                                      error: function(e){
                                                          $('#loading').hide();
                                                          console.log(e);
                                                          alert(e.responseText);
                                                      }
                                                  })     
                                                }
                                      //         $("#txtNNName").prop("disabled", true).css("background-color", "#e8f4ff").val(response_data.name);
                                      //         $("#txtNNPhone").prop("disabled", true).css("background-color", "#e8f4ff").val(response_data.phoneNumber);
                                      //         // test data
                                      //         $("#select_thanhpho").prop("disabled", true).css("background-color", "#e8f4ff").val("203");
                                      //         // Lấy dữ liệu
                                      //               var selectedOption = $("#select_thanhpho").find('option:selected');
                                      //               var dataValue = selectedOption.text();
                                      //               $("#tinh_tp").val(dataValue);
                                      //               $('#loading').show();
                                      //               $("#select_quan").html("");
                                      //                 var selectedValue = $("#select_thanhpho").val();
                                      //                 $.ajax({
                                      //                     method: "GET",
                                      //                     url: 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/district',
                                      //                     headers: {
                                      //                       'Token': 'c61b8d62-a18d-11ee-a6e6-e60958111f48',
                                      //                       'Content-Type': 'application/json'
                                      //                     },
                                      //                     data: {
                                      //                       "province_id": selectedValue
                                      //                     },
                                      //                     success: function(response_quan){
                                      //                         $('#loading').hide();
                                      //                         var data = response_quan.data;
                                      //                         for(let i=0;i<data.length;i++){
                                      //                           $("#select_quan").append($('<option>').val(data[i].DistrictID).text(data[i].DistrictName));
                                      //                         }
                                      //                         // 
                                      //                           $("#select_quan").prop("disabled", true).css("background-color", "#e8f4ff").val(response_data.districtId);
                                      //                           // Lấy dữ liệu
                                      //                                 var selectedOption = $("#select_quan").find('option:selected');
                                      //                                 var dataValue = selectedOption.text();
                                      //                                 $("#quan_huyen").val(dataValue);
                                      //                                 $('#loading').show();
                                      //                                 $("#select_phuong").html("");
                                      //                                   var selectedValue = $("#select_quan").val();
                                      //                                   $.ajax({
                                      //                                       method: "GET",
                                      //                                       url: 'https://dev-online-gateway.ghn.vn/shiip/public-api/master-data/ward',
                                      //                                       headers: {
                                      //                                         'Token': 'c61b8d62-a18d-11ee-a6e6-e60958111f48',
                                      //                                         'Content-Type': 'application/json'
                                      //                                       },
                                      //                                       data: {
                                      //                                         "district_id": selectedValue
                                      //                                       },
                                      //                                       success: function(response_phuong){
                                      //                                           $('#loading').hide();
                                      //                                           var data = response_phuong.data
                                      //                                           for(let i=0;i<data.length;i++){
                                      //                                             $("#select_phuong").append($('<option>').val(data[i].WardCode).text(data[i].WardName));
                                      //                                           }
                                      //                                           // 
                                      //                                             $("#select_phuong").prop("disabled", true).css("background-color", "#e8f4ff").val(response_data.wardCode);
                                      //                                             // lấy dữ liệu
                                      //                                                   var selectedOption = $("#select_phuong").find('option:selected');
                                      //                                                   var dataValue = selectedOption.text();
                                      //                                                   $("#xa_phuong").val(dataValue);
                                                                                        
                                      //                                                   if($("#select_phuong").val()!=""){
                                      //                                                     $('#loading').show();
                                      //                                                     var selectedValue = $("#select_phuong").val();
                                      //                                                     $.ajax({
                                      //                                                         method: "GET",
                                      //                                                         url: 'https://pbl6shopfashion-production.up.railway.app/api/orders/fee-ship?districtId='+$("#select_quan").val()+'&wardCode='+$("#select_phuong").val(),
                                      //                                                         success: function(response_fee){
                                      //                                                             $('#loading').hide();
                                      //                                                             var data = response_fee.data
                                      //                                                             $("#phi_ship").val(data.feeShip);
                                      //                                                             reload_total_price()
                                                                                                  
                                      //                                                         },
                                      //                                                         error: function(e){
                                      //                                                             $('#loading').hide();
                                      //                                                             console.log(e);
                                      //                                                             alert(e.responseText);
                                      //                                                         }
                                      //                                                     })     
                                      //                                                   }
                                      //                                             // 
                                      //                                           // 
                                                                                
                                      //                                       },
                                      //                                       error: function(e){
                                      //                                           $('#loading').hide();
                                      //                                           console.log(e);
                                      //                                           alert(e.responseText);
                                      //                                       }
                                      //                                   })
                                      //                           // 
                                      //                         // 
                                                            
                                      //                     },
                                      //                     error: function(e){
                                      //                         $('#loading').hide();
                                      //                         console.log(e);
                                      //                         alert(e.responseText);
                                      //                     }
                                      //                 })     
                                      //         // 
                                              
                                      //         $("#shippingAddress").prop("disabled", true).css("background-color", "#e8f4ff").val(response_data.street);
                                          },
                                          error: function(e){
                                              $('#loading').hide();
                                              console.log(e);
                                              alert(e.responseText);
                                          }
                                      })     

                                    }else{
                                      $("#txtNNName").val("").show();
                                      $("#txtNNPhone").val("").show();
                                      $("#select_thanhpho").val("").show();
                                      $("#select_quan").val("").show();
                                      $("#select_phuong").val("").show();
                                      $("#shippingAddress").val("").show();
                                    }
                                  })
                              });
                            </script>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <input type="text" name="shippingAddress" id="shippingAddress"   placeholder="Địa chi cụ thể*">
                                <div>
                                    {!! $errors->first('txtNNName') !!}
                                </div>
                              </div>                             
                            </div>
                          </div> 
                           <div class="row">
                            <div class="col-md-12">
                              <div class="aa-checkout-single-bill">
                                <textarea cols="8" name="note"  rows="3" placeholder="Ghi chú"></textarea>
                              </div>                             
                            </div>                            
                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="checkout-right">
                  <h4>Đơn hàng</h4>
                  <div class="aa-order-summary-area">
                    <table class="table table-responsive">
                      <thead>
                        <tr>
                          <th style="border:1px solid #000">Sản phẩm</th>
                          <th style="border:1px solid #000">Thành tiền</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($sanpham as $item)
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
                        <tr>
                          <td style="border:1px solid #000" >{!! $sanpham->sanpham_ten !!} <strong> x  {!! $item->quantity !!}</strong></td>
                          <td style="border:1px solid #000" ><input class="gia_sp" value="{!! $sanpham->actualPrice*$item->quantity !!}" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                          @php
                              $total += $sanpham->actualPrice*$item->quantity
                          @endphp
                        </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th style="border:1px solid #000" >Phí vận chuyển</th>
                          <td style="border:1px solid #000" ><input id="phi_ship" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                        </tr>
                          <tr>
                          <th style="border:1px solid #000" >Giảm giá sản phẩm</th>
                          <td style="border:1px solid #000" ><input id="giam_gia_sp_show" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                        </tr>
                        <tr style="display:none;">
                          <th style="border:1px solid #000" >Giảm giá sản phẩm</th>
                          <td style="border:1px solid #000" ><input id="giam_gia_sp" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                        </tr>
                        <tr style="display:none;">
                          <th style="border:1px solid #000" >Kiểu giảm giá SP</th>
                          <td style="border:1px solid #000" ><input id="kieu_giam_gia_sp" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                        </tr>
                        <tr>
                          <th style="border:1px solid #000" >Giảm giá vận chuyển</th>
                          <td style="border:1px solid #000" ><input id="giam_gia_vc_show" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                        </tr>
                        <tr style="display:none;">
                          <th style="border:1px solid #000" >Giảm giá vận chuyển</th>
                          <td style="border:1px solid #000" ><input id="giam_gia_vc" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                        </tr>
                        <tr style="display:none;">
                          <th style="border:1px solid #000" >Kiểu giảm giá VC</th>
                          <td style="border:1px solid #000" ><input id="kieu_giam_gia_vc" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td>
                        </tr>

                        <tr>
                          <th style="border:1px solid #000" >Tổng cộng</th>
                          <td style="border:1px solid #000" ><input id="tong_cong" style="
    text-align: center;
    width: 100px;
    background-color: #faebd700;
    border: none;
" disabled></td> </td>
                        </tr>
                        
                      </tfoot>
                    </table>
                  </div>
                  
                </div>
              </div>
              {{-- Data --}}
              <input type="text" id="totalPayment" name="totalPayment" val="{!! $total !!}" style="display:none"> 
              <input type="text" id="tinh_tp" name="tinh_tp" val="" style="display:none">
              <input type="text" id="quan_huyen" name="quan_huyen" val="" style="display:none">
              <input type="text" id="xa_phuong" name="xa_phuong" val="" style="display:none"> 
              <input type="text" id="maxDiscountValue_sp" name="maxDiscountValue_sp" val="" style="display:none">
              <input type="text" id="maxDiscountValue_vc" name="maxDiscountValue_vc" val="" style="display:none">

            </div>
          </form>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->
 <!-- Footer -->
@include('frontend.blocks.footer')
<!-- / Footer -->
@stop