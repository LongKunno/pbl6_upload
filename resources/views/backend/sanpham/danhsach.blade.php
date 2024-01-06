@extends('backend.master')
@section('title')
        <h3 class="page-header ">
        Sản phẩm / 
            <a href="{!! URL::route('admin.sanpham.getAdd') !!}"  style="margin-top:-8px;" class="btn btn-info">Thêm mới</a>
        </h3>
@stop
@section('content')                 
<div class="panel panel-default">
<div class="panel-heading">
    <b><i>Danh sách sản phẩm</i></b>
</div>
<!-- /.panel-heading -->
<div class="panel-body">
    <div class="dataTable_wrapper">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>Ký hiệu</th>
                <th>Ảnh</th>
                <th>Tên</th>
                <th>Loại</th>
                <th>Xóa</th>
                <th>Sửa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->items as $item)
            <tr class="odd gradeX" align="left">
                <td>{!! $item->product_id !!}</td>
                <td>
                    @if (!empty($item->product_image[0]))
                        <img src="{!! $item->product_image[0] !!}" class="img-responsive img-rounded" alt="Image" style="width: 70px; height: 40px;">
                    @else
                        <img src="#" class="img-responsive img-rounded" alt="Image" style="width: 70px; height: 40px;">
                    @endif
                
                </td>
                <td>{!! $item->product_name !!}</td>
                <td>
                    @if (!empty($item->brand_name))
                        {!! $item->brand_name !!}
                    @else
                        {!! NULL !!}
                    @endif
                </td>
                <td class="center">
                <a href="{!! URL::route('admin.sanpham.getDelete', $item->product_id ) !!}" onclick="return confirmDel('Bạn có chắc muốn xóa dữ liệu này?')" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Xóa"><i class="fa fa-trash-o  fa-fw"></i></a></td>
                </td>
                <td class="center" > <a href="{!! URL::route('admin.sanpham.getEdit', $item->product_id ) !!}" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Chỉnh sửa"><i class="fa fa-pencil fa-fw"></i></a></td>
                {{-- <td class="center">
                <a style="display:none"  href="{!! URL::route('admin.lohang.getNhaphang', [$item->product_id] ) !!}" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Nhập hàng"><i class="fa fa-plus"></i></a>
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <!-- /.row -->
</div>
</div>

@stop



