@extends('backend.master')
@section('title')
    <h3 class="page-header">
        Đơn hàng
    </h3>
@stop
@section('content')                 
<div class="panel panel-default">
<div class="panel-heading">
    <b><i>Danh sách đơn hàng</i></b>
</div>
<!-- /.panel-heading -->
<div class="panel-body">
<div class="tab-content">
    <div class="tab-pane fade in active" id="home">
        <br>
        <div class="dataTable_wrapper">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt hàng</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr class="odd gradeX">
                    <td>{!! $item->id !!}</td>
                    <td>{!! $item->name !!}</td>
                    <td>{!! $item->orderStatus !!}</td>
                    <td>{!! $item->totalProductAmount !!}</td>
                    <td>{!! $item->orderDate !!}</td>
                    
                    <td align="center">
                    <a href="{!! URL::route('admin.donhang.getEdit1', $item->id ) !!}" 
                        type="button" class="btn btn-primary" 
                        data-toggle="tooltip" data-placement="left" 
                        title="Thông tin chi tiết">
                        <i class="fa fa-crosshairs"></i>
                    </a>
                    <a href="{!! URL::route('admin.donhang.getEdit2', $item->id ) !!}" 
                       type="button" class="btn btn-danger" 
                       data-toggle="tooltip" data-placement="left" 
                       title="Chuyển trạng thái tiếp theo">
                        <i class="fa fa-credit-card"></i>
                    </a>
                    <a href="{!! URL::route('admin.donhang.pdf', $item->id ) !!}" 
                       type="button" class="btn btn-default" 
                       data-toggle="tooltip" data-placement="left" 
                       title="In hóa đơn">
                        <i class="fa fa-print"></i>
                    </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        </div>

        </div>
        </div>

    <!-- /.row -->
</div>
</div>
@stop
