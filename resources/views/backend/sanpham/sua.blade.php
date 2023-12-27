@extends('backend.master')

@section('content')
<style type="text/css" media="screen">
    .icon_del{
        position: relative;
        top: -200px;
        left: 150px;
    }
</style>
    <form action="" method="POST"  enctype="multipart/form-data" id="form_update_product" name="frmEditPro">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
    <div class="row">
<div class="col-lg-12 ">
<div class="panel panel-green">
    <div class="panel-heading" style="height:60px;">
      <h3 >
        <a href="{!! URL::route('admin.sanpham.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Sản phẩm</i></a>
        /Cập nhật
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
                    <input class="form-control" id="sp_name" name="txtSPName" value="{!! $data_product->productName !!}" placeholder="Nhập tên sản phẩm..." />
                    <div>
                        {!! $errors->first('txtSPName') !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Giá</label>
                    <input class="form-control" id="sp_price" name="price" value="{!! $data_product->price !!}" placeholder="Nhập giá sản phẩm" pattern="[0-9]+" title="Chỉ cho phép nhập số nguyên dương" />
                    <div>
                        {!! $errors->first('txtSPSignt') !!}
                    </div>
                </div>
            </div>
            
            
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" rows="3" id="sp_intro" name="update_txtSPIntro" placeholder="Mô tả..."> {!! $data_product->decription !!}</textarea>
                    <script type="text/javascript">CKEDITOR.replace('update_txtSPIntro'); </script>
                    {{-- <script type="text/javascript">
                        CKEDITOR.replace('sp_intro');
                        CKEDITOR.on('instanceReady', function(evt) {
                            var editor = evt.editor;
                            editor.setData('{!! $data_product->decription !!}');
                        });
                    </script> --}}
                    <div>
                        {!! $errors->first('update_txtSPIntro') !!}
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
                            <label style="margin-right:10px;"> <input id="size_id_2" type="checkbox" data-id={{ $s['id'] }} name="sizes[]" value="{{ $s['name'] }}">{{ $s['name'] }} : <input style="width: 40px;" type="text" id="size_soluong_{{ $s['id'] }}" pattern="[0-9]+" title="Chỉ cho phép nhập số nguyên dương"></label>
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
                    <input type="file" name="txtSPImage_update" multiple>
                    <div>
                        {!! $errors->first('txtSPImage_update') !!}
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
    $(document).ready(function(){
        $("#form_update_product #select_catology").val({!! $data_product->categoryType !!})
        $("#form_update_product #select_brand").val({!! $data_product->brandType !!})
        $("#form_update_product #select_brand").val({!! $data_product->brandType !!})
        
        var list_size_id = {!! json_encode($data_product->sizeTypes) !!};
        var list_size_quantity = {!! json_encode($data_product->sizeQuantity) !!};
        for(var i=0;i<=list_size_id.length;i++){
            $("#form_update_product #size_soluong_"+list_size_id[i]).val(list_size_quantity[i])
        }
        $("#form_update_product #select_promotion").val({!! $data_product->brandType !!})

        //submit
        $("#form_update_product").submit(function(e) {
            e.preventDefault();
            $('#loading').show();

            // Tạo biểu mẫu gửi dữ liệu
            var formData = new FormData();
            var name = $("#form_update_product #sp_name").val()
            var price = $("#form_update_product #sp_price").val()
            var desc = $("#form_update_product #sp_intro").val()
            var categoryId = $("#form_update_product #select_catology").val()
            var brandId = $("#form_update_product #select_brand").val()
            var unit = $("#form_update_product #select_unit").val()
            var productSizes = [];
            $("input[name='sizes[]']:checked").each(function() {
                productSizes.push($(this).val()+":"+$("#form_update_product #size_soluong_"+$(this).data("id")).val());
            });
            var promotionId = $("#form_update_product #select_promotion").val()

            formData.append("name", name);
            formData.append("price", price);
            formData.append("desc", desc);
            formData.append("categoryId", categoryId);
            formData.append("brandId", brandId);
            formData.append("unit", unit);
            formData.append("productSizes", productSizes);
            formData.append("promotionId", promotionId);

            
            // Thêm thông tin hình ảnh vào biểu mẫu gửi dữ liệu
            var images = $("input[type='file'][name='txtSPImage_update']")[0].files;
            for (var i = 0; i < images.length; i++) {
                formData.append("images", images[i]);
            }
            // Gửi yêu cầu Ajax
            $.ajax({
                method: "patch",
                url: "https://pbl6shopfashion-production.up.railway.app/api/product/{!! $data_product->productId !!}",
                contentType: false,
                processData: false,
                data: formData,
                dataType: "html",
                success: function(response){
                    $('#loading').hide();
                    alert("Cập nhật sản phẩm thành công!");
                },
                error: function(){
                    $('#loading').hide();
                    alert("Cập nhật sản phẩm thất bại!");
                }
            })     
        });
    })
</script>
@stop