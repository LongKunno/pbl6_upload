@extends('backend.master')

@section('content')
<form action="" method="POST"  enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
        <div class="col-lg-12 ">
        <div class="panel panel-green">
            <div class="panel-heading" style="height:60px;">
              <h3 >
                <a href="{!! URL::route('admin.thongtin.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Thông tin Giày</i></a>
                /Cập nhật
              </h3>
            <div class="navbar-right" style="margin-right:10px;margin-top:-50px;">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{!! URL::route('admin.thongtin.list') !!}" ><i class="btn btn-default" >Hủy</i></a>
            </div>
            </div>
            <div class="panel-body">
        <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Cập nhật bài viết</h3>
            </div>
            <div class="panel-body">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Tiêu đề</label>
                <input class="form-control" name="txtMNTittle" value="{!! $thongtin->thongtin_tieu_de !!}"/>
                <div>
                    {!! $errors->first('txtMNTittle') !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Tóm tắt</label>
                <textarea class="form-control" rows="2" name="txtMNResum" placeholder="Mô tả...">{!! $thongtin->thongtin_tom_tat !!}</textarea>
                <script type="text/javascript">CKEDITOR.replace('txtMNResum'); </script>
                <div>
                    {!! $errors->first('txtMNResum') !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Nội dung</label>
                <textarea class="form-control" rows="3" name="txtMNContent" placeholder="Mô tả...">{!! $thongtin->thongtin_noi_dung !!}</textarea>
                <script type="text/javascript">CKEDITOR.replace('txtMNContent'); </script>
                <div>
                    {!! $errors->first('txtMNContent') !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Ảnh đại diện</label>
                <br>
                <img src="{!! asset('public/images/thongtin/'.$thongtin->thongtin_anh) !!}" class="img-responsive img-rounded" alt="Image" style="width: 150px; height: 200px;">
                <input type="hidden" name="fImageCurrent" value="{!! $thongtin->thongtin_anh !!}">
                <br>
                <input type="file" name="fImage" >
            </div>
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