@extends('backend.master')

@section('content')
<form action="{!! route('admin.khuyenmai.getAdd') !!}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
        <div class="col-lg-12 ">
        <div class="panel panel-green">
            <div class="panel-heading" style="height:60px;">
              <h3 >
                <a href="{!! URL::route('admin.khuyenmai.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Khuyến mãi</i></a>
                /Thêm mới
              </h3>
            <div class="navbar-right" style="margin-right:10px;margin-top:-50px;">
                <button type="submit" class="btn btn-primary">Lưu</button><a href="{!! URL::route('admin.khuyenmai.list') !!}" ><i class="btn btn-default" >Hủy</i></a>
            </div>
            </div>
            <div class="panel-body">
        <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Thông tin khuyến mãi</h3>
            </div>
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="txtKMTittle" value="{!! old('txtKMTittle') !!}" placeholder="Tiêu đề..." />
                        <div>
                            {!! $errors->first('txtKMTittle') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" rows="3" name="txtKMContent" placeholder="Mô tả...">{!! old('txtKMContent') !!}</textarea>
                        <script type="text/javascript">CKEDITOR.replace('txtKMContent'); </script>
                        <div>
                            {!! $errors->first('txtKMContent') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                        <div class="form-group">
                            <label>Giá trị khuyến mãi</label>
                            <input class="form-control" type="number" name="txtKMPer" value="{!! old('txtKMPer') !!}" placeholder="VD: 10,20,30,..." />
                            <div>
                                {!! $errors->first('txtKMPer') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Thời gian bắt đầu khuyến mãi</label>
                            <input type="datetime-local" class="form-control" id='khuyenmai_them_startDate' name='khuyenmai_them_startDate' placeholder="YYYY-MM-DD">
                            <div>
                                {!! $errors->first('txtKMTime') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Thời gian kết thúc khuyến mãi</label>
                            <input type="datetime-local" class="form-control" id='khuyenmai_them_endDate' name='khuyenmai_them_endDate' placeholder="YYYY-MM-DD">
                            <div>
                                {!! $errors->first('txtKMTime') !!}
                            </div>
                        </div>
                    </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label>Kiểu giảm giá</label>
                        <select class="form-control" name="khuyenmai_them_discountType">
                            <option value="AMOUNT" >AMOUNT</option>
                            <option value="PERCENTAGE" >PERCENTAGE</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default " style="margin-left:-22px;">
                <div class="panel-heading">
                    <h3 class="panel-title">Thêm sản phẩm khuyến mãi</h3>
                </div>
            <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_product as $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="products[{!! $item['id'] !!}]" id="{!! $item['id'] !!}" value="{!! $item['id'] !!}">
                        </td>
                        <td>
                            {!! $item['name'] !!}
                        </td>
                    </tr>
                    @endforeach
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