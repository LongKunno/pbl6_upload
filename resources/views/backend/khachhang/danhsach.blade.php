@extends('backend.master')
@section('title')
    <h3 class="page-header ">
        Khách hàng
    </h3>
@stop
@section('content')                 
<div class="panel panel-default">
<div class="panel-heading">
    <b><i>Danh sách khách hàng</i></b>
</div>
<!-- /.panel-heading -->
<div class="panel-body">
    <div class="dataTable_wrapper">

    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr class="odd gradeX" align="center">
                <th >ID</th>
                <th >Tên TK</th>
                <th >SĐT</th>
                <th >Email</th>
                <th >Loại TK</th>
                <th >Trạng thái</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
                // dd($data);
            @endphp
             @foreach ($data as $item)
            <tr class="odd gradeX">
                <td>{!! $item->id !!}</td>
                <td>{!! $item->username !!}</td>
                <td>{!! $item->phoneNumber !!}</td>
                <td>{!! $item->gmail !!}</td>
                <td>{!! $item->role !!}</td>
                
                @php
                    if($item->locked){
                        echo("<td> Đã khoá </td>");
                    }
                    else {
                        echo("<td> Đang hoạt động </td>");
                    }
                @endphp
                @php
                    if($item->role != "ADMIN"){
                        if($item->locked)
                            echo '<td class="center"><a onclick="return confirmDel(\'Bạn có chắc muốn mở dữ liệu này?\')" href="' . URL::route('admin.khachhang.getDelete', $item->id) . '" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Mở khoá"><i class="fa fa-trash-o fa-fw"></i></a></td>';
                        else {
                            echo '<td class="center"><a onclick="return confirmDel(\'Bạn có chắc muốn khoá dữ liệu này?\')" href="' . URL::route('admin.khachhang.getDelete', $item->id) . '" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a></td>';
                        }
                    }
                    else {
                        echo('<td class="center"></td>');
                    }
                @endphp
                <td class="center"><a href="{!! URL::route('admin.khachhang.getHistory', $item->id ) !!}" type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Xem lịch sử mua hàng"><i class="fa fa-history"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    <!-- /.row -->
</div>
</div>

@stop