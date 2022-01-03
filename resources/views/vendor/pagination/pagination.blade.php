@if ($paginator->hasPages())
  <nav class="pagination-nav">
    <ul class="pagination">
      @if (!$paginator->onFirstPage())
        <li class="page-item pre">
          <a class="page-link" href="{{ $paginator->previousPageUrl().$inputs_params }}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>&nbsp;戻る
          </a>
        </li>
      @endif
      @if ($paginator->hasMorePages())
        <li class="page-item next">
          <a class="page-link" href="{{ $paginator->nextPageUrl().$inputs_params }}" aria-label="Next">
            次へ&nbsp;<span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      @endif
    </ul>
  </nav>
@endif