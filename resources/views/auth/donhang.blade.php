@extends('frontend.master')

@section('content')
 <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="{!! url('public/images/careerpanel.jpg') !!}" alt="fashion img" style="width: 1920px; height: 300px;" >
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Danh sách đơn hàng</h2>
        <ol class="breadcrumb">
          <li><a href="{!! url('/') !!}">Home</a></li>         
          <li class="active">Danh sách đơn hàng</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  </section>
  <!-- / product category -->
 <!-- Cart view section -->
 <section id="aa-myaccount"> 

    <div class="panel panel-default">
    <!-- .panel-heading -->
    <div class="panel-body" style="
    background-color: #b4c2ff;
">
        <div class="panel-group" id="accordion">
            @foreach ($data as $item)
            <?php 
                switch ($item->orderStatus) {
                    case 'DELIVERED':
                        $color = "green";
                        break;
                    case 'UNCONFIRMED':
                        $color = "#af8a00";
                        break;
                    default:
                        $color = "#b30000";
                        break;
                }
            ?>
            <div class="panel panel-{{$color}}" style="background-color: #b4c2ff">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$item->id}}" ><p style="color:{{$color}};"><b>Đơn hàng số {{ $item->id }} | <i>Tình trạng:</i> {{$item->orderStatus}}</b></p></a>

                    </h4>
                </div>
                <div id="collapse{{$item->id}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">
                        <div class="col-lg-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thông tin khách hàng</h3>
                        </div>
                        <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td><b>Tên khách hàng</b></td>
                                        <td>{!! $khachhang->khachhang_ten !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Số điện thoại</b></td>
                                        <td>{!! $khachhang->khachhang_sdt !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td>{!! $khachhang->khachhang_email !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Địa chỉ</b></td>
                                        <td>{!! $khachhang->khachhang_dia_chi !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>    
                        </div>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thông tin giao hàng</h3>
                        </div>
                        <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">

                                <tbody>
                                    <tr>
                                        <td><b>Người nhận hàng</b></td>
                                        <td>{!! $item->name !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Số điện thoại</b></td>
                                        <td>{!! $item->phoneNumber !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Địa chỉ</b></td>
                                        <td>{!! $item->shippingAddress !!}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Ghi chú</b></td>
                                        <td>
                                        @if (!asset($item->note))
                                            {{ $item->note }}
                                        @else
                                            Không có ghi chú
                                        @endif
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div> 
                        </div>
                        </div>
                        <?php 
                            $url = 'https://pbl6shopfashion-production.up.railway.app/api/orders/'.$item->id;
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
                            $data_init = json_decode($response);
                            $data_orders_product = $data_init->orderItems;
                        ?>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h2 class="panel-title" ><b>Danh sách sản phẩm</b></h2>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12" >
                                    <div class="table-responsive">
                                        <table class="table table-hovered" >
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Đơn giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $count = 0; ?>
                                                @foreach ($data_orders_product as $val)
                                                    <tr>
                                                        <td>{!! $count = $count + 1 !!}</td>
                                                        <td>
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
                                                        <td>
                                                        {!! number_format($val->unitPrice,0,",",".") !!} vnđ 
                                                        </td>
                                                        <td>{!! $val->quantity !!}</td>
                                                        <td>{!! number_format($val->unitPrice*$val->quantity,0,",",".") !!} vnđ </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                <td colspan="5">
                                                <b>Tổng tiền sản phẩm : {!! number_format("$item->totalProductAmount",0,",",".") !!} vnđ </b>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="5">
                                                Chi phí vận chuyển : {!! number_format("$item->shippingFee",0,",",".") !!} vnđ 
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="5">
                                                Giảm giá sản phẩm : {!! number_format("$item->discountAmount",0,",",".") !!} vnđ 
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="5">
                                                Giảm giá vận chuyển : {!! number_format("$item->discountShippingFee",0,",",".") !!} vnđ 
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="5">
                                                <b>Số tiền thực tế phải trả : {!! number_format("$item->totalPayment",0,",",".") !!} vnđ </b>
                                                    @if ()
                                                        <a href="{!! url("huydonhang",$item->id) !!}">
                                                            <button style="float: right; background-color: #3498db; color: #fff; border: none; font-size: 16px; padding: 10px 20px; margin-top: 10px;">Huỷ đơn hàng</button>
                                                        </a>
                                                    @endif
                                                    @if ()
                                                        <a href="{!! url("danhgiasanpham") !!}">
                                                            <button style="float: right; background-color: #3498db; color: #fff; border: none; font-size: 16px; padding: 10px 20px; margin-top: 10px;">Đánh giá</button>
                                                        </a>
                                                    @endif
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- .panel-body -->
    </div>
    <!-- /.panel -->

 </section>
 <!-- / Cart view section -->
@endsection
