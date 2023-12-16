<div class="aa-sidebar-widget">
  <h3>Bài viết mới</h3>
  <div class="aa-recently-views">
  <?php $thongtin = DB::table('thongtin')->orderBy('id','desc')->take(5)->get(); ?>
    <ul>
    @foreach ($thongtin as $item)
      <li>
        <a href="{!! url('thong-tin',$item->thongtin_url) !!}"><img src="{!! asset('resources/upload/thongtin/'.$item->thongtin_anh) !!}" alt="img"  style="width: 100px; height: 100px;"></a>
        <div class="aa-cartbox-info">
          <h4><a href="{!! url('thong-tin',$item->thongtin_url) !!}">{!! $item->thongtin_tieu_de !!}</a></h4>
          <p>{{date("d-m-Y", strtotime("$item->created_at"))}}</p>
        </div>                    
      </li>
    @endforeach                                         
    </ul>
  </div>                            
</div>