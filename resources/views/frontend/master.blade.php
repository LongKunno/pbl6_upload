<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Shop giày No Name</title>
    
    <!-- Font awesome -->
    <link href="{{ url('public/frontend/css/font-awesome.css') }}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ url('public/frontend/css/bootstrap.css') }}" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="{{ url('public/frontend/css/jquery.smartmenus.bootstrap.css') }}" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="{{ url('public/frontend/css/jquery.simpleLens.css') }}">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="{{ url('public/frontend/css/slick.css') }}">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="{{ url('public/frontend/css/nouislider.css') }}">
    <!-- Theme color -->
    <link id="switcher" href="{{ url('public/frontend/css/theme-color/purple-theme.css') }}" rel="stylesheet">
    <!-- <link id="switcher" href="css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="{{ url('public/frontend/css/sequence-theme.modern-slide-in.css') }}" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="{{ url('public/frontend/css/style.css') }}" rel="stylesheet">    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href="{{ url('public/frontend/magiczoomplus/magiczoomplus.css') }}" rel="stylesheet">
    <script src="{{ url('public/frontend/magiczoomplus/magiczoomplus.js') }}"></script>
  </head>
  <body> 
     <!-- wpf loader Two -->
    <!-- <div id="wpf-loader-two">          
      <div class="wpf-loader-two-inner">
        <span>Đang tải</span>
      </div>
    </div>  -->
    <!-- / wpf loader Two -->       
 <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
  <!-- END SCROLL TOP BUTTON -->
  
    <!-- Start header section -->
	<header id="aa-header">
    <!-- start header top  -->
    <div class="aa-header-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-top-area">
            <!-- start header top left -->
              <div class="aa-header-top-left">
                <!-- start language -->
                
                <div class="cellphone hidden-xs">
                  <p>Sơn Trà - Đà Nẵng</p>
                </div>
                <!-- / language -->

                <!-- start cellphone -->
                <div class="cellphone hidden-xs">
                  <p><span class="fa fa-phone"></span>0919900743</p>
                </div>
                <!-- / cellphone -->
              </div>
              <!-- / header top left -->
              <div class="aa-header-top-right">
                <ul class="aa-head-top-nav-right">
                  @if (request()->hasCookie('access_token'))
                    <img href="{{ url('/update-imformation') }}" src="{!! asset('public/images/avatar.jpg') !!}" alt="fashion img" style="border-radius: 50%;width: 22px;height: 22px;">
                    <li class="hidden-xs"><a href="{{ url('/update-imformation') }}">{{ request()->cookie('fullName') }}</a></li>
                    <li class="hidden-xs"><a href="{{ url('/donhang') }}">Đơn hàng</a></li>
                    <li class="hidden-xs"><a href="{{ url('/logout') }}">Thoát</a></li>
                  @else
                    <li class="hidden-xs"><a href="{{ url('/getregister') }}">Đăng kí</a></li>
                    <li class="hidden-xs"><a href="{{ url('/login') }}">Đăng nhập</a></li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header top  -->

    <!-- start header bottom  -->
    <div class="aa-header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-header-bottom-area">
              <!-- logo  -->
              <div class="aa-logo">
                <!-- Text based logo -->
                <a href="{!! URL('/') !!}">
                  <span class="fa fa-shopping-cart"></span>
                  <p>Shop giày <strong>No Name</strong> <span>Giá tốt - Chất lượng cao</span></p>
                </a>
                <!-- img based logo -->
                <!-- <a href="index.html"><img src="img/logo.jpg" alt="logo img"></a> -->
              </div>
              <!-- / logo  -->
               <!-- cart box -->
              <div class="aa-cartbox">
                <a class="aa-cart-link" href="{!! url('gio-hang') !!}">
                  <span class="fa fa-shopping-basket"></span>
                  <span class="aa-cart-title">GIỎ HÀNG</span>
                  <span class="aa-cart-notify">
                     <?php 
                          $url = 'https://pbl6shopfashion-production.up.railway.app/api/carts/user/'.request()->cookie('user_id').'/count';
                          $postData = array();
                          $postData = json_encode($postData);
                          $ch = curl_init();
                          curl_setopt($ch, CURLOPT_URL, $url);
                          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                          curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                          $headers = array(
                              "Authorization: Bearer " . request()->cookie('access_token'),
                              "Content-Type: application/json"
                          );
                          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                          // Thực hiện yêu cầu POST
                          $response = curl_exec($ch);
                          // Kiểm tra lỗi
                          if (curl_errno($ch)) {
                              $error = curl_error($ch);
                              dd($error);
                          }
                          // Đóng kết nối cURL
                          curl_close($ch);
                          $count = json_decode($response);
                          if (!is_numeric($count)) {
                              $count = 0;
                          }
                          print_r($count);
                       ?>
                  </span>
                </a>
              </div>
              <!-- / cart box -->
              <!-- search box -->
              @include('frontend.blocks.seach')
              <!-- / search box -->             
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <!-- / header section -->
    <!-- menu -->
  <section id="menu">
    <div class="container">
      <div class="menu-area">
        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>          
          </div>
          <!-- Start menu -->
          @include('frontend.blocks.menu')
          <!-- End menu -->
        </div>
      </div>       
    </div>
  </section>
  <!-- / menu -->
  <!-- Content pages -->
  
    @yield('content')

  <!-- / Content pages -->

  <!-- / product category -->
    <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="{{ url('public/frontend/js/bootstrap.js') }}"></script>  
  <!-- SmartMenus jQuery plugin -->
  <script type="text/javascript" src="{{ url('public/frontend/js/jquery.smartmenus.js') }}"></script>
  <!-- SmartMenus jQuery Bootstrap Addon -->
  <script type="text/javascript" src="{{ url('public/frontend/js/jquery.smartmenus.bootstrap.js') }}"></script>  
  <!-- To Slider JS -->
  <script src="{{ url('public/frontend/js/sequence.js') }}"></script>
  <script src="{{ url('public/frontend/js/sequence-theme.modern-slide-in.js') }}"></script>  
  <!-- Product view slider -->
  <script type="text/javascript" src="{{ url('public/frontend/js/jquery.simpleGallery.js') }}"></script>
  <script type="text/javascript" src="{{ url('public/frontend/js/jquery.simpleLens.js') }}"></script>
  <!-- slick slider -->
  <script type="text/javascript" src="{{ url('public/frontend/js/slick.js') }}"></script>
  <!-- Price picker slider -->
  <script type="text/javascript" src="{{ url('public/frontend/js/nouislider.js') }}"></script>
  <!-- Custom js -->
  <script src="{{ url('public/frontend/js/custom.js') }}"></script> 

  <!-- My scripts -->
  <script src="{{ url('public/frontend/js/myscript.js') }}"></script> 
  </body>
</html>