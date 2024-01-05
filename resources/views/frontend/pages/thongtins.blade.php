@extends('frontend.master')
@section('content')

  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
   <img src="{!! url('public/images/thongtingiay.jpg') !!}" alt="fashion img" style="width: 1920px; height: 300px;" >
   <div class="aa-catg-head-banner-area">
     <div class="container">
      <div class="aa-catg-head-banner-content">
        <h2>Blog</h2>
        <ol class="breadcrumb">
          <li><a href="{!! url('/') !!}">Home</a></li>         
          <li class="active">Blog</li>
        </ol>
      </div>
     </div>
   </div>
  </section>
  <!-- / product category -->

  <section id="aa-blog-archive">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="aa-blog-archive-area aa-blog-archive-2">
            <div class="row">             
        
                <div class="aa-blog-content">
                  <div class="row">
                  @foreach ($thongtin as $item)
                  <div class="col-md-4 col-sm-4">
                      <article class="aa-latest-blog-single">
                        <figure class="aa-blog-img">                    
                          <a href="{!! url('thong-tin',$item->thongtin_url) !!}"><img src="{!! asset('public/images/thongtin/'.$item->thongtin_anh) !!}"  style="width: 450px; height: 220px;"></a>  
                            <figcaption class="aa-blog-img-caption">
                            <span href="{!! url('thong-tin',$item->thongtin_url) !!}"><i class="fa fa-clock-o"></i>{!! $item->created_at !!}</span>
                          </figcaption>                          
                        </figure>
                        <div class="aa-blog-info">
                          <h3 class="aa-blog-title"><a href="{!! url('thong-tin',$item->thongtin_url) !!}">{!! $item->thongtin_tieu_de !!}</a></h3>
                          <p>{!! cut($item->thongtin_tom_tat,100) !!}</p> 
                          <a class="aa-read-mor-btn" href="{!! url('thong-tin',$item->thongtin_url) !!}">Xem tiếp <span class="fa fa-long-arrow-right"></span></a>
                        </div>
                      </article>
                    </div>
                @endforeach            
                  </div>
                </div>
                <!-- Blog Pagination -->
                <div class="aa-blog-archive-pagination">
                  <nav>
                    <ul class="pagination">
                    @if ($thongtin->currentPage() != 1)
                      <li>
                        <a href="{!! str_replace('/?','?',$thongtin->url($thongtin->currentPage() - 1)) !!}" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>
                    @endif
                    @for ($i = 1; $i <=  $thongtin->lastPage(); $i++)
                      <li class="{!! ($thongtin->currentPage() == $i)? 'active':'' !!}"><a href="{!! str_replace('/?','?',$thongtin->url($i)) !!}">{!! $i !!}</a></li>
                    @endfor
                    @if ($thongtin->currentPage() != $thongtin->lastPage())
                      <li>
                        <a href="{!! str_replace('/?','?',$thongtin->url($thongtin->currentPage() + 1)) !!}" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>
                    @endif
                      
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
    </section>
<!-- Footer -->
@include('frontend.blocks.footer')
<!-- / Footer -->
@stop