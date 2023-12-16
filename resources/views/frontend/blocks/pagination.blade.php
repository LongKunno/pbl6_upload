<div class="aa-product-catg-pagination">
  <?php 
    $url_current = url()->current(); 
  ?>
  <nav>
    <ul class="pagination">
    @if ($data->currentPage > 1)
      <li>
        <a href="{!! $url_current."?page=".($data->currentPage-1) !!}" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
    @endif
    @for ($i = 1; $i <=  $data->totalPages; $i++)
      <li class=""><a href="{!! $url_current."?page=".$i !!}">{!! $i !!}</a></li>
    @endfor
    @if ($data->currentPage < $data->totalPages)
      <li>
        <a href="{!! $url_current."?page=".($data->currentPage+1) !!}" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    @endif
      
    </ul>
  </nav>
</div>