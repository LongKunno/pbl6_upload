@extends('frontend.master')

@section('content')

<div class="container" style="padding-top:200px">
    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Quên mật khẩu</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/forgot-password') }}">
                        {!! csrf_field() !!}
                         <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                        <center>
                            @if (isset($error))
                                <span class="help-block">
                                    <strong><div style="color:red;margin-bottom:30px;">{{$error}}</div></strong>
                                </span>
                            @endif
                        </center>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Tên đăng nhập: <span>*</span></label>

                            <div class="col-md-6">
                                <input type="username" class="form-control" name="username" value="{{ old('username') }}">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="aa-browse-btn">
                                    <i class="fa fa-btn fa-sign-in"></i>Xác nhận
                                </button>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
