@extends('frontend.master')
@section('content')
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="{!! $sanpham[0]->img_brand !!}" alt="fashion img" style="width: 100%; height: 300px;">
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>{!! $sanpham[0]->brand_name !!}</h2>
        <ol class="breadcrumb">
          <li><a href="{!! url('/') !!}">Home</a></li>         
          <li class="active">{!! $sanpham[0]->brand_name !!}</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / catg header banner section -->
  <!-- product category -->
  <section id="aa-product-category">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
          <div class="aa-product-catg-content">
            @include('frontend.blocks.head')
            <div class="aa-product-catg-body">
              <ul class="aa-product-catg">
                <!-- start single product item -->
                @foreach ($sanpham as $item)
                <li>
                  <figure>
                    @if (isset($item->product_image[0])) 
                      <a class="aa-product-img" href="{!! url('san-pham',$item->product_id) !!}"><img src="{!! $item->product_image[0] !!}"  style="width: 250px; height: 300px;"></a>
                    @else
                      <a class="aa-product-img" href="{!! url('san-pham',$item->product_id) !!}"><img src="https://bizweb.dktcdn.net/100/332/013/themes/685588/assets/no-product.jpg?1675674448471"  style="width: 250px; height: 300px;"></a>
                    @endif
                    <a class="aa-add-card-btn" href="{!! url('san-pham',$item->product_id) !!}"><span class="fa fa-shopping-cart"></span>Mua ngay</a>
                    <figcaption>
                      <h4 class="aa-product-title"><a href="{!! url('san-pham',$item->product_id) !!}">{!! $item->product_name !!}</a></h4>
                      <input type="hidden" name="txtqty" value="1" />
                      @if (!empty($item->discount_value)) 
                       <!-- product badge -->

                    <span class="aa-badge aa-sold-out" >Khuyến mãi!</span>
                    <span class="aa-product-price">

                      
                        {!! number_format($item->price_promote,0,",",".") !!} vnđ
                    </span>
                    <span class="aa-product-price">
                    <del>{!! number_format("$item->price",0,",",".") !!} vnđ</del>
                    </span> 
                     <input type="hidden" name="txtopt" value="{!! $item->discount_value !!}" /> 
                     @else
                         <span class="aa-product-price">
                         {!! number_format("$item->price",0,",",".") !!} vnđ
                         </span>
                         <input type="hidden" name="txtopt" value="1" /> 
                    @endif
                      </figcaption>
                  </figure>
                </li> 
                @endforeach                                      
              </ul>

            </div>
            <!-- pagination -->

            @include('frontend.blocks.pagination')

            <!-- /pagination -->
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-md-pull-9">
          <aside class="aa-sidebar">
             <!-- sidebar  1 -->
            
            @include('frontend.blocks.spbanchay')
             <!-- sidebar 2 -->
          
          </aside>
        </div>
       
      </div>
    </div>
  </section>
  <!-- / product category -->
  <!-- Footer -->
@include('frontend.blocks.footer')
<!-- / Footer -->
@stop
