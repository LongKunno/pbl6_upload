@extends('backend.master')
@section('title')
    <h3 class="page-header">
        Blog /
        <a href="{!! URL::route('admin.thongtin.getAdd') !!}" class="btn btn-info" style="margin-top:-8px;">Đăng bài</a>
    </h3>
@stop
@section('content')                 
<div class="panel panel-default">
<div class="panel-heading">
    <b><i>Danh sách bài viết</i></b>
</div>
<!-- /.panel-heading -->
<div class="panel-body">
    <div class="dataTable_wrapper">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr class="odd gradeX" align="center">
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Ngày đăng</th>
                <th>Xóa</th>
                <th>Sửa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
           <tr class="odd gradeX">
                <td>{!! $item->id !!}</td>
                <td>
                <img src="{!! asset('public/images/thongtin/'.$item->thongtin_anh) !!}" class="img-responsive img-rounded" alt="Image" style="width: 70px; height: 40px;">
                </td>
                <td>{!! $item->thongtin_tieu_de !!}</td>
                <td>{!! date("d-m-Y",strtotime($item->created_at)) !!}</td>
                <td class="center">
                <a onclick="return confirmDel('Bạn có chắc muốn xóa dữ liệu này?')" href="{!! URL::route('admin.thongtin.getDelete', $item->id ) !!}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Xóa"><i class="fa fa-trash-o  fa-fw"></i></a></td>
                <td class="center"><a href="{!! URL::route('admin.thongtin.getEdit', $item->id ) !!}" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Chỉnh sửa"><i class="fa fa-pencil fa-fw"></i></a>
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
