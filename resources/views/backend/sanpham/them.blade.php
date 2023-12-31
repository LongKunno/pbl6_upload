@extends('backend.master')

@section('content')
<form action="{!! route('admin.sanpham.getAdd') !!}" method="POST" id="FormAddSanPham"  enctype="multipart/form-data">
<input type="hidden" name="_token" value="{!! csrf_token() !!}" />
<div class="row">
<div class="col-lg-12 ">
<div class="panel panel-green">
    <div class="panel-heading" style="height:60px;">
      <h3 >
        <a href="{!! URL::route('admin.sanpham.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Sản phẩm</i></a>
        /Thêm mới
      </h3>
    <div class="navbar-right" style="margin-right:10px;margin-top:-50px;">
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{!! URL::route('admin.sanpham.list') !!}" ><i class="btn btn-default" >Hủy</i></a>
    </div>
    </div>
    <div class="panel-body">
        <div class="col-lg-7">
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Tên</label>
                    <input class="form-control" id="sp_name" name="txtSPName" value="{!! old('txtSPName') !!}" placeholder="Nhập tên sản phẩm..." />
                    <div>
                        {!! $errors->first('txtSPName') !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Giá</label>
                    <input class="form-control" id="sp_price" name="price" placeholder="Nhập giá sản phẩm" pattern="[0-9]+" title="Chỉ cho phép nhập số nguyên dương" />
                    <div>
                        {!! $errors->first('txtSPSignt') !!}
                    </div>
                </div>
            </div>
            
            
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" rows="3" id="sp_intro" name="txtSPIntro" placeholder="Mô tả..."> {!! old('txtSPIntro') !!}</textarea>
                    <script type="text/javascript">CKEDITOR.replace('sp_intro'); </script>
                    <div>
                        {!! $errors->first('sp_intro') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
           <div class="col-lg-12">
                <div class="form-group">
                    <label>Loại sản phẩm</label>
                    <div >
                        <select name="txtSPCate" id="select_catology" class="form-control">
                            <option >--Chọn loại sản phẩm--</option>
                            <?php Select_Function($category); ?>
                        </select>
                    </div>
                    <div>
                        {!! $errors->first('txtSPCate') !!}
                    </div>
                </div>
            </div>
           <div class="col-lg-12">
                <div class="form-group">
                    <label>Thương hiệu</label>
                    <div >
                        <select name="txtSPBrand" id="select_brand" class="form-control">
                            <option >--Chọn thương hiệu--</option>
                            <?php Select_Function($brand); ?>
                        </select>
                    </div>
                    <div>
                        {!! $errors->first('txtSPCate') !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Đơn vị tính</label>
                    <div >
                        <select name="txtSPUnit" id="select_unit" class="form-control">
                            <option >--Chọn đơn vị tính--</option>
                            <?php Select_Function($unit); ?>
                        </select>
                    </div>
                    <div>
                        {!! $errors->first('txtSPUnit') !!}
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label>Size</label>
                    <div>
                        @foreach($size as $s)
                            <label style="margin-right:10px;">{{ $s['name'] }} : <input style="width: 40px;" type="text" class="txt_them_size_soluong" data-name="{{ $s['name'] }}" id="size_soluong_{{ $s['id'] }}" pattern="[0-9]+" title="Chỉ cho phép nhập số nguyên dương"></label>
                        @endforeach
                    </div>
                    <div>
                        {!! $errors->first('sizes') !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Khuyến mãi</label>
                    <div >
                        <select name="txtSPPromotion" id="select_promotion" class="form-control">
                            <option value="" >--Chọn khuyến mãi--</option>
                            <?php Select_Function($promotion); ?>
                        </select>
                    </div>
                    <div>
                        {!! $errors->first('txtSPPromotion') !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Hình ảnh </label>
                    <input type="file" name="txtSPImage" multiple>
                    <div>
                        {!! $errors->first('txtSPImage') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>   
</div>
</form>

<script>
$(document).ready(function() {
    
    $("#FormAddSanPham").submit(function(e) {
        e.preventDefault();
        $('#loading').show();
        

        // Tạo biểu mẫu gửi dữ liệu
        var formData = new FormData();
        var name = $("#sp_name").val()
        var price = $("#sp_price").val()
        var desc = CKEDITOR.instances.sp_intro.getData();
        var categoryId = $("#select_catology").val()
        var brandId = $("#select_brand").val()
        var unit = $("#select_unit").val()
        var productSizes = [];
        $(".txt_them_size_soluong").each(function() {
            if($(this).val()){
                productSizes.push($(this).attr("data-name")+":"+$(this).val());
            }
        });
        var promotionId = $("#select_promotion").val()
        //test

        formData.append("name", name);
        formData.append("price", price);
        formData.append("desc", desc);
        formData.append("categoryId", categoryId);
        formData.append("brandId", brandId);
        formData.append("unit", unit);
        formData.append("productSizes", productSizes);
        if(promotionId!=""){
            formData.append("promotionId", promotionId);
        }
        

        
        // Thêm thông tin hình ảnh vào biểu mẫu gửi dữ liệu
        var images = $("input[type='file'][name='txtSPImage']")[0].files;
        for (var i = 0; i < images.length; i++) {
            formData.append("images", images[i]);
        }
        // Gửi yêu cầu Ajax
        $.ajax({
            method: "post",
            url: "https://pbl6shopfashion-production.up.railway.app/api/product",
            contentType: false,
            processData: false,
            data: formData,
            dataType: "html",
            success: function(response){
                $('#loading').hide();
                console.log(response);
                alert("Thêm sản phẩm thành công!");
            },
            error: function(response){
                $('#loading').hide();
                console.log(response.responseText);
                alert("Thêm sản phẩm thất bại!");
            }
        })     
    });
})
</script>

@stop