@extends('backend.master')

@section('content')

    <form action="{!! route('admin.voucher.getAdd') !!}" method="POST">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
        <div class="col-lg-12 ">
        <div class="panel panel-green">
            <div class="panel-heading" style="height:60px;">
              <h3 >
                <a href="{!! URL::route('admin.voucher.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Voucher</i></a>
                /Thêm mới
              </h3>
            <div class="navbar-right" style="margin-right:10px;margin-top:-50px;">
                <button type="submit" class="btn btn-primary">Lưu</button>
                <a href="{!! URL::route('admin.voucher.list') !!}" ><i class="btn btn-default" >Hủy</i></a>
            </div>
            </div>
            <div class="panel-body">
            <div class="col-lg-7">
                <div class="form-group">
                    <label>Code</label>
                    <input class="form-control" name="voucher_them_code" value="{!! old('voucher_them_code') !!}" placeholder="Nhập Code..." />
                    <div>
                        {!! $errors->first('voucher_them_code') !!}
                    </div>
                </div>

                <div class="form-group">
                    <label>Ngày hết hạn</label>
                    <input type="datetime-local" class="form-control" name="voucher_them_expiryDate" placeholder="YYYY-MM-DD">
                    <div>
                        {!! $errors->first('voucher_them_expiryDate') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control" rows="2" name="voucher_them_description" placeholder="Địa chỉ...">{!! old('txtNCCAdress') !!}</textarea>
                    <script type="text/javascript">CKEDITOR.replace('voucher_them_description'); </script>
                    <div>
                        {!! $errors->first('voucher_them_description') !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label>Kiểu giảm giá</label>
                    <select class="form-control" name="voucher_them_discountType">
                        <option value="AMOUNT">AMOUNT</option>
                        <option value="PERCENTAGE" >PERCENTAGE</option>
                    </select>
                    <div>
                        {!! $errors->first('voucher_them_discountType') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>Kiểu Voucher</label>
                    <select class="form-control" name="voucher_them_voucherType">
                        <option value="PURCHASE">PURCHASE</option>
                        <option value="FREE_SHIP" >FREE_SHIP</option>
                    </select>
                    <div>
                        {!! $errors->first('voucher_them_voucherType') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>Giá trị giảm giá</label>
                    <input class="form-control" name="voucher_them_discountValue" type="number" value="{!! old('txtNCCName') !!}" placeholder="Nhập giá trị giảm giá..." />
                    <div>
                        {!! $errors->first('voucher_them_discountValue') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>Giá trị giảm giá tối đa</label>
                    <input class="form-control" name="voucher_them_maxDiscountValue" type="number" value="{!! old('txtNCCName') !!}" placeholder="Nhập giá trị giảm giá..." />
                    <div>
                        {!! $errors->first('voucher_them_maxDiscountValue') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>Giá trị giảm giá tối thiểu</label>
                    <input class="form-control" name="voucher_them_minimumPurchaseAmount" type="number" value="{!! old('txtNCCName') !!}" placeholder="Nhập giá trị giảm giá..." />
                    <div>
                        {!! $errors->first('voucher_them_minimumPurchaseAmount') !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>Giới hạn sử dụng</label>
                    <input class="form-control" name="voucher_them_usageLimit" type="number" value="{!! old('txtNCCName') !!}" placeholder="Nhập giới hạn sử dụng..." />
                    <div>
                        {!! $errors->first('voucher_them_usageLimit') !!}
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    <form>

@stop