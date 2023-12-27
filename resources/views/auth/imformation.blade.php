@extends('frontend.master')

@section('content')
 <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="{!! url('public/images/careerpanel.jpg') !!}" alt="fashion img" style="width: 1920px; height: 300px;" >
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Cập nhật thông tin</h2>
        <ol class="breadcrumb">
          <li><a href="{!! url('/') !!}">Home</a></li>         
          <li class="active">Cập nhật thông tin tài khoản</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  </section>
  <!-- / product category -->
 <!-- Cart view section -->
 <section id="aa-myaccount">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
        <div class="aa-myaccount-area" style="
    padding-top: 10px;
">         
            <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/post-update-imformation') }}">
                        {!! csrf_field() !!}
                <div class="col-md-12">
                <div class="aa-myaccount-login">
                    <center>
                        <h4>Thông tin tài khoản</h4>
                        @if (isset($error))
                            <span class="help-block">
                                <strong><div style="color:red;margin-bottom:30px;">{{$error}}</div></strong>
                            </span>
                        @endif
                        
                    </center>


<center>
   <div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);">
      <img href="{{ url('/update-imformation') }}" src="{!! asset('public/images/avatar.jpg') !!}" alt="fashion img" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid #ccc;">
   </div>
   <div style="margin-bottom: 30px; font-weight: bold;"><label>Ảnh đại diện</label></div>
</center>





                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Tài khoản</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="info_username" value="{{ $user_info->username }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('txtname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Tên khách hàng</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="info_name" value="{{ $user_info->name }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('txtname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Gmail</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="info_gmail" value="{{ $user_info->gmail }}" pattern="[a-zA-Z0-9._%+-]+@gmail.com" title="Vui lòng nhập địa chỉ Gmail hợp lệ">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('txtname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Địa chỉ</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="info_address" value="{{ $user_info->address }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('txtname') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Giới tính</label>
                            <div class="col-md-6">
                                <select class="form-control" name="info_gender">
                                    <option value="MALE" {{ $user_info->gender == 'MALE' ? 'selected' : '' }}>Male</option>
                                    <option value="FEMALE" {{ $user_info->gender == 'FEMALE' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            </div>

                            <div class="form-group{{ $errors->has('txtname') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Ngày sinh</label>
                            @php
                                $newDate = date("Y-m-d", strtotime($user_info->birthday));
                            @endphp
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="info_birthday" value={{ $newDate }} placeholder="YYYY-MM-DD">
                            </div>
                            </div>

                            <div class="form-group{{ $errors->has('txtname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Số điện thoại</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="info_phoneNumber" value="{{ $user_info->phoneNumber }}" pattern="[0-9]+" title="Vui lòng chỉ nhập số">
                                </div>
                            </div>


                        </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="aa-browse-btn" style="margin-left: 25%;">
                            <i class="fa fa-btn fa-user"></i>Cập nhật
                        </button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
   </div>
 </section>
 <!-- / Cart view section -->
@endsection
