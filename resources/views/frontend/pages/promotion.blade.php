@extends('frontend.master')
@section('content')
  <!-- catg header banner section -->
<section id="aa-catg-head-banner">
  <img src="{!! asset('public/images/promotionpanel.jpg') !!}" alt="fashion img" style="width: 1920px; height: 300px;" >
    <div class="aa-catg-head-banner-area">
      <div class="container">
        <div class="aa-catg-head-banner-content">
        <h2 style="font:30px tahoma, sans-serif;">Khuyến mãi</h2>
          <ol class="breadcrumb">
            <li><a href="{!! url('/') !!}">Home</a></li>         
            <li class="active">Khuyến mãi</li>
          </ol>
        </div>
      </div>
    </div>
</section>
@foreach ($list_khuyen_mai as $khuyenmai)

      <!-- Start Promo section -->
    <!-- / Promo section -->
      <!-- / product category -->
    <section id="aa-blog-archive">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="aa-blog-archive-area" style="padding-bottom: 0px;">
              <div class="row">
                <div class="col-md-12">
                  <!-- Blog details -->
                  <div class="aa-blog-content aa-blog-details"  style="font:10px arial, sans-serif;">
                  @if (!is_null($khuyenmai))
                    <?php 
                      $startAt = $khuyenmai->data->promotion->startAt;
                      $endAt = $khuyenmai->data->promotion->endAt;
                      $ngaybd =  date("Y-m-d", strtotime("$startAt")); // Năm/Tháng/Ngày
                      $ngaykt = date("Y-m-d",strtotime("$endAt"));
                    ?>
                    
                    <!-- blog navigation -->
                    <div class="aa-product-related-item">
              
          
                        <p style="color: #ce009b;margin-bottom: 5%;font-size: x-large;text-align: center;">
                      {!! $khuyenmai->data->promotion->name !!}:
                      <b>{{date('d/m/Y',strtotime($ngaybd))}}</b>
                      đến
                      <b>{{date('d/m/Y',strtotime($ngaykt))}}</b>
                      ({!! $khuyenmai->data->promotion->description !!})
                      </p>
                  
                      <ul class="aa-product-catg aa-related-item-slider">
                        <!-- start single product item -->
              @foreach ($khuyenmai->data->products as $sanpham)
            <li>
              <figure>
                <a class="aa-product-img" href="{!! url('san-pham',$sanpham->id) !!}"><img src="{!! $sanpham->imageUrls[0] !!}" style="width: 250px; height: 300px;" alt="polo shirt img"></a>
                
                <a class="aa-add-card-btn" href="{!! url('mua-hang',[$sanpham->id,$sanpham->id]) !!}"><span class="fa fa-shopping-cart"></span>Mua ngay</a>
                <figcaption>
                  <h4 class="aa-product-title"><a href="{!! url('san-pham',$sanpham->id) !!}">{!! $sanpham->name !!}</a></h4>
                  <input type="hidden" name="txtqty" value="1" />
                </figcaption>
                                  
                          
                <!-- product badge -->
                <span class="aa-badge aa-sold-out" >Khuyến mãi!</span>
                <span class="aa-product-price">
              <?php
                if(empty($khuyenmai->data->promotion->discountValue))
                  $khuyenmai_phan_tram = 0;
                else {
                  $khuyenmai_phan_tram = $khuyenmai->data->promotion->discountValue;
                }
                $tyle = $khuyenmai_phan_tram*0.01;
                $giakm = ($sanpham->price - ($sanpham->price * $tyle));
                ?> 
                {!! number_format($giakm,0,",",".") !!} vnđ
                </span>
                <span class="aa-product-price">
                  <del>{!! number_format("$sanpham->price",0,",",".") !!} vnđ</del>
                </span> 
                </figure> 
                <input type="hidden" name="txtopt" value="{!! $tyle !!}" />
              </li>
              @endforeach
                                                                                                        
              </ul>
            </div> 
            @else
              <article class="aa-blog-content-single" >                 
                <div class="aa-article-bottom">
                <p>
                Hiện tại cửa hàng chưa có chương trình khuyến mãi...
                </p>
                  </div>
              </article>
            @endif
                    
                </div>
                </div>
                </div>        
            </div>
          </div>
        </div>
      </div>
    
  </section>
  @endforeach
  <!-- Footer -->
@include('frontend.blocks.footer')
<!-- / Footer -->
@stop