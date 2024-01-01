@extends('backend.master')

@section('content')
<form action="" method="POST">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
     <div class="row">
        <div class="col-lg-12 ">
        <div class="panel panel-green">
            <div class="panel-heading" style="height:60px;">
              <h3 >
                <a href="{!! URL::route('admin.donhang.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Quản lý đơn hàng</i></a>
                /Cập nhật thông tin giao hàng đơn hàng số {{$data->id}}
              </h3>
            <div class="navbar-right" style="margin-right:10px;margin-top:-50px;">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{!! URL::route('admin.donhang.list') !!}" ><i class="btn btn-default" >Hủy</i></a>
            </div>
            </div>
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
                          <td>{!! $data->name !!}</td>
                      </tr>
                      <tr>
                          <td><b>Số điện thoại</b></td>
                          <td>{!! $data->phoneNumber !!}</td>
                      </tr>
                      <tr>
                          <td><b>Địa chỉ</b></td>
                          <td>{!! $data->shippingAddress !!}</td>
                      </tr>
                  </tbody>
              </table>
          </div>    
        </div>
        </div>
        <div class="col-lg-12">
        <br>
            <div class="form-group">
                <label for="input" >Tình trạng đơn hàng</label>
                <div>
                    <select id="select_order_status" name="select_order_status" class="form-control" >
                      <?php
                        foreach ($order_status as $option) {
                              if ($option["name"]== $data->orderStatus) {
                                echo '<option value="' . $option["id"] . '" selected>' . $option["name"] . '</option>';
                              } else {
                                echo '<option value="' . $option["id"] . '">' . $option["name"] . '</option>';
                              }
                        }
                      ?>
                  </select>
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
                          <td><b>Tên người nhận</b></td>
                          <td>{!! $data->name !!}</td>
                      </tr>
                      <tr>
                          <td><b>Số điện thoại</b></td>
                          <td>{!! $data->phoneNumber !!}</td>
                      </tr>
                      <tr>
                          <td><b>Địa chỉ</b></td>
                          <td>{!! $data->shippingAddress !!}</td>
                      </tr>
                      <tr>
                          <td><b>Ghi chú</b></td>
                          <td>{!! $data->note !!}</td>
                      </tr>
                  </tbody>
              </table>
          </div>    
        </div>
        </div> 
        </div>
    </div>
    <div class="row">
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
                        <?php 
                            $count = 0; 
                            $tongtien = 0; 
                        ?>
                            @foreach ($data->orderItems as $val)
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
                                    @php
                                        $tongtien += $val->unitPrice*$val->quantity
                                    @endphp
                                </tr>
                            @endforeach
                            <tr>
                            <td colspan="5">
                            <b>Tổng tiền : {!! number_format("$tongtien",0,",",".") !!} vnđ </b>
                                
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
  </form>
@stop