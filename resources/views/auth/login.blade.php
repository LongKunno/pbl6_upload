@extends('frontend.master')

@section('content')

<div class="container" style="padding-top:200px">
    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Đăng nhập</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/postlogin') }}">
                        {!! csrf_field() !!}
                         <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                        <div class="form-group">
                            <label class="col-md-4 control-label">Username</label></label>

                            <div class="col-md-6">
                                <input type="username" class="form-control" name="username" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="aa-browse-btn">
                                    <i class="fa fa-btn fa-sign-in"></i>Đăng nhập
                                </button>

                                <a class="aa-browse-btn" href="{{ url('/getregister') }}" type="button"> <i class="fa fa-registered"></i>Đăng kí</a>
                                <br>
                                <div style="margin-right: 100px;margin-top: 10px;">
                                    <center>
                                        <a mar href="https://pbl6shopfashion-production.up.railway.app/oauth2/authorization/google" class="btn btn-primary facebook">  <i class="fa fa-facebook"></i> </a>
                                        <a mar href="https://pbl6shopfashion-production.up.railway.app/oauth2/authorization/google" class="btn btn-primary facebook">  <i class="fa fa-google"></i> </a>
                                        <a mar href="https://pbl6shopfashion-production.up.railway.app/oauth2/authorization/google" class="btn btn-primary facebook">  <i class="fa fa-github"></i> </a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
