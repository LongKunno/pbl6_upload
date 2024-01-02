@extends('backend.master')

@section('content')
<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
        <div class="col-lg-12 ">
        <div class="panel panel-green">
            <div class="panel-heading" style="height:60px;">
              <h3 >
                <a href="{!! URL::route('admin.khuyenmai.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Khuyến mãi</i></a>
                /Cập nhật
              </h3>
            <div class="navbar-right" style="margin-right:10px;margin-top:-50px;">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{!! URL::route('admin.khuyenmai.list') !!}" ><i class="btn btn-default" >Hủy</i></a>
            </div>
            </div>
            <div class="panel-body">
        <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Thông tin khuyến mãi</h3>
            </div>
            <div class="panel-body">
            <div class="col-lg-12">
            <div class="form-group">
                <label>Tiêu đề</label>
                <input class="form-control" name="txtKMTittle" value="{!! $data->data->promotion->name !!}" placeholder="Tiêu đề..." />
                <div>
                    {!! $errors->first('txtKMTittle') !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="3" name="txtKMContent" placeholder="Mô tả...">{!! $data->data->promotion->description !!}</textarea>
                <script type="text/javascript">CKEDITOR.replace('txtKMContent'); </script>
                <div>
                    {!! $errors->first('txtKMContent') !!}
                </div>
            </div>
        </div>
        <div class="col-lg-12">
                <div class="form-group">
                    <label>Giá trị khuyến mãi</label>
                    <input class="form-control" name="txtKMPer" value="{!! $data->data->promotion->discountValue !!}" placeholder="VD: 10,20,30,..." />
                    <div>
                        {!! $errors->first('txtKMPer') !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Thời gian bắt đầu khuyến mãi</label>
                        <input type="datetime-local" class="form-control" id='khuyenmai_them_startDate' name='khuyenmai_them_startDate' placeholder="YYYY-MM-DD">
                        <script>
                            var expiryDate = "{!! $data->data->promotion->startAt !!}";
                            var parts = expiryDate.split(" ");
                            var formattedDate = parts[1].split("-").reverse().join("-") + "T" + parts[0];
                            document.getElementById('khuyenmai_them_startDate').value = formattedDate;
                        </script>
                    <div>
                        {!! $errors->first('txtKMTime') !!}
                    </div>
                </div>
            </div>
        <div class="col-lg-12">
                <div class="form-group">
                    <label>Thời gian kết thúc khuyến mãi</label>
                    <input type="datetime-local" class="form-control" id='khuyenmai_them_endDate' name='khuyenmai_them_endDate' placeholder="YYYY-MM-DD">
                    <script>
                            var expiryDate = "{!! $data->data->promotion->endAt !!}";
                            var parts = expiryDate.split(" ");
                            var formattedDate = parts[1].split("-").reverse().join("-") + "T" + parts[0];
                            document.getElementById('khuyenmai_them_endDate').value = formattedDate;
                        </script>
                    <div>
                        {!! $errors->first('txtKMTime') !!}
                    </div>
                </div>
            </div>
        <div class="col-lg-12">
            <div class="form-group">
                <label>Kiểu giảm giá</label>
                <select class="form-control" name="khuyenmai_them_discountType">
                    <?php
                        foreach ($list_discountType as $option) {
                              if ($option["name"]== $data->data->promotion->discountType) {
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
    </div>
     <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Sản phẩm khuyến mãi</h3>
                </div>
            <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th></th>
                        <th class="col-lg-12">Sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_product as $item)
                    <tr>
                        <td>
                            @php
                                $products = $data->data->products;
                                $ids = array_map(function($products) {
                                    return $products->id;
                                }, $products);
                            @endphp 
                            @if (in_array($item['id'],$ids) )
                                <input type="checkbox" name="products[{!! $item['id'] !!}]" id="{!! $item['id'] !!}" value="{!! $item['id'] !!}" checked>
                            @else
                                <input type="checkbox" name="products[{!! $item['id'] !!}]" id="{!! $item['id'] !!}" value="{!! $item['id'] !!}">
                            @endif
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