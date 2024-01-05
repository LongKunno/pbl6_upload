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
                    case 'CONFIRMED':
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
                                                    <th>Đánh giá</th>
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
                                                        @if ($item->orderStatus == "DELIVERED")
                                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-id="{!! $val->productId !!}" data-target="#modal_create_task_data">
                                                                Đánh giá
                                                            </button></td>
                                                        @else
                                                            <td><button type="button" class="btn btn-primary" disabled>
                                                                Chưa hoàn thành
                                                            </button></td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                <td colspan="6">
                                                <b>Tổng tiền sản phẩm : {!! number_format("$item->totalProductAmount",0,",",".") !!} vnđ </b>
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="6">
                                                Chi phí vận chuyển : {!! number_format("$item->shippingFee",0,",",".") !!} vnđ 
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="6">
                                                Giảm giá sản phẩm : {!! number_format("$item->discountAmount",0,",",".") !!} vnđ 
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="6">
                                                Giảm giá vận chuyển : {!! number_format("$item->discountShippingFee",0,",",".") !!} vnđ 
                                                </td>
                                                </tr>
                                                <tr>
                                                <td colspan="6">
                                                <b>Số tiền thực tế phải trả : {!! number_format("$item->totalPayment",0,",",".") !!} vnđ </b>
                                                    @if ($item->orderStatus == "CONFIRMED")
                                                        <a href="{!! url("huydonhang",$item->id) !!}">
                                                            <button style="float: right; background-color: #3498db; color: #fff; border: none; font-size: 16px; padding: 10px 20px; margin-top: 10px;">Huỷ đơn hàng</button>
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

  <div class="modal"  id="modal_create_task_data" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Thêm bình luận</h5>
      </div>
      <div class="modal-body"> 
        <label>Mức độ hài lòng</label>
        <select id="select_mucdohailong" class="form-control" >
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <label style="margin-top:15px;">Đánh giá</label>
        <input id="danhgiasanpham" type="text" class="form-control" placeholder="Đánh giá"> 
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



@endsection
