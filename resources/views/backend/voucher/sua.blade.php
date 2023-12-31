@extends('backend.master')

@section('content')

    <form action="" method="POST">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
        <div class="col-lg-12 ">
        <div class="panel panel-green">
            <div class="panel-heading" style="height:60px;">
              <h3 >
                <a href="{!! URL::route('admin.voucher.list') !!}" style="color:blue;"><i class="fa fa-product-hunt" style="color:blue;">Voucher</i></a>
                /Cập nhật
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
                        <input class="form-control" name="voucher_sua_code" value="{!! $data->code !!}"  placeholder="Nhập Code..." readonly />
                        <div>
                            {!! $errors->first('voucher_sua_code') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ngày hết hạn</label>
                        <input type="datetime-local" class="form-control" id="voucher_sua_expiryDate" name="voucher_sua_expiryDate" placeholder="YYYY-MM-DD">
                        <script>
                            var expiryDate = "{!! $data->expiryDate !!}";
                            var parts = expiryDate.split(" ");
                            var formattedDate = parts[1].split("-").reverse().join("-") + "T" + parts[0];
                            document.getElementById('voucher_sua_expiryDate').value = formattedDate;
                        </script>
                        <div>
                            {!! $errors->first('voucher_sua_expiryDate') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" rows="2" name="voucher_sua_description" placeholder="Địa chỉ...">{!! $data->description !!}</textarea>
                        <script type="text/javascript">CKEDITOR.replace('voucher_sua_description'); </script>
                        <div>
                            {!! $errors->first('voucher_sua_description') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                        <label>Kiểu giảm giá</label>
                        <select class="form-control" name="voucher_sua_discountType">
                            <option value="AMOUNT" {{ $data->discountType == 'AMOUNT' ? 'selected' : '' }} >AMOUNT</option>
                            <option value="PERCENTAGE" {{ $data->discountType == 'PERCENTAGE' ? 'selected' : '' }} >PERCENTAGE</option>
                        </select>
                        <div>
                            {!! $errors->first('voucher_sua_discountType') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Kiểu Voucher</label>
                        <select class="form-control" name="voucher_sua_voucherType">
                            <option value="PURCHASE" {{ $data->voucherType == 'PURCHASE' ? 'selected' : '' }} >PURCHASE</option>
                            <option value="FREE_SHIP" {{ $data->voucherType == 'FREE_SHIP' ? 'selected' : '' }} >FREE_SHIP</option>
                        </select>
                        <div>
                            {!! $errors->first('voucher_sua_voucherType') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Giá trị giảm giá</label>
                        <input class="form-control" name="voucher_sua_discountValue" type="number" value="{!! $data->discountValue !!}" placeholder="Nhập giá trị giảm giá..." />
                        <div>
                            {!! $errors->first('voucher_sua_discountValue') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Giá trị giảm giá tối đa</label>
                        <input class="form-control" name="voucher_sua_maxDiscountValue" type="number" value="{!! $data->maxDiscountValue !!}" placeholder="Nhập giá trị giảm giá..." />
                        <div>
                            {!! $errors->first('voucher_sua_maxDiscountValue') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Giá trị giảm giá tối thiểu</label>
                        <input class="form-control" name="voucher_sua_minimumPurchaseAmount" type="number" value="{!! $data->minimumPurchaseAmount !!}" placeholder="Nhập giá trị giảm giá..." />
                        <div>
                            {!! $errors->first('voucher_sua_minimumPurchaseAmount') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Giới hạn sử dụng</label>
                        <input class="form-control" name="voucher_sua_usageLimit" type="number" value="{!! $data->usageLimit !!}" placeholder="Nhập giới hạn sử dụng..." />
                        <div>
                            {!! $errors->first('voucher_sua_usageLimit') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select class="form-control" name="voucher_sua_active">
                            <option value="true" {{ $data->active ? 'selected' : '' }} >Hoạt động</option>
                            <option value="false" {{ !$data->active  ? 'selected' : '' }} >Không hoạt động</option>
                        </select>
                        <div>
                            {!! $errors->first('voucher_sua_active') !!}
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        </div>
    <form>

@stop