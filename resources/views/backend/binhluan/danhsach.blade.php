@extends('backend.master')
@section('title')
    <h1 class="page-header">Bình luận</h1>
@stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Danh sách các bình luận
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
                    <th>Tên khách hàng</th>
                    <th>Số sao</th>
                    <th>Ngày</th>
                    <th>Nội dung</th>
                    <th>Action</th>
                 
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr class="odd gradeX">
                    <td>{!! $item->id !!}</td>
                    <td>{!! $item->name !!}</td>
                    <td>
                        {!! $item->rate !!}
                    </td>
                    <td>{!! date("d-m-Y",strtotime($item->createAt)) !!}</td>
                    <td>{!! $item->content !!}</td>
                    
                    <td align="center">
                    <a onclick="return confirmDel('Bạn có chắc muốn xóa dữ liệu này?')" href="{!! URL::route('admin.binhluan.getDelete', $item->id ) !!}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Xóa"><i class="fa fa-trash-o  fa-fw"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        </div>
    </div>
    <!-- /.panel-body -->
@stop
