@extends('backend.master')
@section('title')
    <h3 class="page-header ">
        Khuyến mãi / 
        <a href="{!! URL::route('admin.khuyenmai.getAdd') !!}" class="btn btn-info" style="margin-top:-8px;" >Thêm mới</a>
    </h3>
@stop
@section('content')                 
<div class="panel panel-default">
<div class="panel-heading">
    <b><i>Danh sách tin khuyến mãi</i></b>
</div>
<!-- /.panel-heading -->
<div class="panel-body">
    <div class="dataTable_wrapper">

    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr align="center">
                <th>ID</th>
                <th>Status</th>
                <th>Chủ đề</th>
                <th>Tỷ lệ</th>
                <th>Bắt đầu</th>
                <th>Kết thúc</th>
                <th>Xóa</th>
                <th>Sửa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
           <tr class="odd gradeX">
                <td>{!! $item->id !!}</td>
                <td>
                    <?php 
                        if ( $item->active )
                        {
                            print_r('Còn KM');
                        } else{
                            print_r('Hết KM');
                        }   
                     ?> 
                </td>
                <td>{!! $item->name !!}</td>
                <td>{!! $item->discountValue !!}%</td>
                <td>{!! $item->startAt !!}</td>
                <td>{!! $item->endAt !!}</td>
                <td>
                <a onclick="return confirmDel('Bạn có chắc muốn xóa dữ liệu này?')" href="{!! URL::route('admin.khuyenmai.getDelete', $item->id ) !!}" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Xóa"><i class="fa fa-trash-o  fa-fw"></i></a>
                </td>
                <td class="center"><a href="{!! URL::route('admin.khuyenmai.getEdit', $item->id ) !!}" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Chỉnh sửa"><i class="fa fa-pencil fa-fw"></i></a>
                </td>

            </tr>
           @endforeach
        </tbody>
    </table>
</div>
    <!-- /.row -->

@stop
