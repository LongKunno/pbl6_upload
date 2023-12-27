@extends('backend.master')
@section('title')
    <h1 class="page-header">Bảng điều khiển</h1>
@stop
@section('content')
<?php 
    $url = 'https://pbl6shopfashion-production.up.railway.app/api/statistical';
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
    $thongtin = json_decode($response);
?>
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$thongtin->comment}}</div>
                        <div>Bình luận!</div>
                    </div>
                </div>
            </div>
            <a  href="{!! URL::route('admin.binhluan.list') !!}">
                <div class="panel-footer">
                    <span class="pull-left">Xem chi tiết</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$thongtin->user}}</div>
                        <div>Khách hàng!</div>
                    </div>
                </div>
            </div>
            <a href="{!! URL::route('admin.khachhang.list') !!}">
                <div class="panel-footer">
                    <span class="pull-left">Xem chi tiết</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$thongtin->order}}</div>
                        <div>Đơn hàng!</div>
                    </div>
                </div>
            </div>
            <a href="{!! URL::route('admin.donhang.list') !!}">
                <div class="panel-footer">
                    <span class="pull-left">Xem chi tiết</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-barcode fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{$thongtin->product}}</div>
                        <div>Sản phẩm</div>
                    </div>
                </div>
            </div>
            <a href="{!! URL::route('admin.sanpham.list') !!}">
                <div class="panel-footer">
                    <span class="pull-left">Xem chi tiết</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<?php 
    $url = 'https://pbl6shopfashion-production.up.railway.app/api/statistical/revenueStatistics';
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
    $thongtin = json_decode($response);
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Sơ đồ thống kê sản phẩm hàng tháng
            </div>
            <!-- /.panel-heading -->
            <div class="container-fluid">
                <canvas id="RadarChart" style="width:50%;"></canvas>
            </div>
            <!-- So do so luong san pham hang thang -->

            <?php
                //tổng sl theo từng tháng
                for ($i= 0; $i < count($thongtin) ; $i++) {
                    $keys[] = 'Tháng '. $thongtin[$i]->month;
                    $val[] = array($thongtin[$i]->soldNumber,$thongtin[$i]->totalAmount/1000000);
                }
                $data = array_combine($keys, $val);
                $options['legends'] = ["Bán ra","Thu nhập"];
            ?>
            <!-- /So do so luong san pham hang thang -->
            {!! app()->chartbar->render("RadarChart", $data, $options) !!}
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <!-- /.panel -->
    </div>
{{-- 
    @include('backend.blocks.doanhthu')
    @include('backend.blocks.comment') --}}
</div>
<!-- /.row -->

@stop
