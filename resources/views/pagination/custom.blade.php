@if ($paginator->hasPages())
<div class="d-flex py-3 py-lg-5 align-items-center justify-content-center">
  <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-end">
      	@if ($paginator->onFirstPage()) 
        	<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        @else
        	<li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
        @endif        
        @foreach ($elements as $element)
        @if(is_string($element))
        <li class="page-item disabled"><span>{{ $element }}</span></li>
        @endif
        @if(is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="page-item"><span class="page-link active">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
        @endforeach
        
        @if ($paginator->hasMorePages())        
        	<li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a></li>
        @else
        	<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
        @endif
      </ul>
  </nav>
</div>
@endif

<style>
	.active>.page-link, .page-link.active {
		z-index: 3;
		color: var(--bs-pagination-active-color);
		background-color: #cff4fc;
		border-color: var(--bs-gray-400);
	}
</style>