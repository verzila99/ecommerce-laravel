<div class="pagination-container">

    <nav class="pagination is-centered" role="navigation"
         aria-label="pagination">

        @if( $paginator->currentPage()!==1)
            <a href="{{$paginator->previousPageUrl() }}"
               class="pagination-previous">Предыдущая</a>
        @endif
        @if( $paginator->currentPage()!== $paginator->lastPage())
            <a href="{{$paginator->nextPageUrl()}}" class="pagination-next">Следующая</a>
        @endif

        <ul class="pagination-list">

            @if(  $paginator->currentPage() > 4)
                <li><a href="{{ $paginator->url(1) }}" class="pagination-link"
                       aria-label="Goto page 1">1</a></li>
            @endif
            @if( $paginator->currentPage()>4)
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
            @endif

            @if( $paginator->currentPage()>2)
                <li><a href="{{ $paginator->url( $paginator->currentPage()-2)}}"
                       class="pagination-link"
                       aria-label="Goto page  {{ $paginator->currentPage()-2 }}"> {{ $paginator->currentPage()-2 }}</a>
                </li>
            @endif
            @if( $paginator->currentPage()>1)
                <li><a href="{{ $paginator->previousPageUrl()}}"
                       class="pagination-link"
                       aria-label="Goto page  {{ $paginator->currentPage()-1 }}"> {{ $paginator->currentPage()-1 }}</a>
                </li>
            @endif

            <li><a class="pagination-link is-current"
                   aria-label="{{ $paginator->currentPage() }}"
                   aria-current="page">{{ $paginator->currentPage() }}</a></li>


            @if($paginator->currentPage() < $paginator->lastPage()-1)
                <li><a href="{{$paginator->nextPageUrl()}}"
                       class="pagination-link"
                       aria-label="Goto page {{ $paginator->currentPage()+1 }}">{{ $paginator->currentPage()+1 }}</a>
                </li>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage()-2)
                <li><a href="{{$paginator->url( $paginator->currentPage()+2)}}"
                       class="pagination-link"
                       aria-label="Goto page {{ $paginator->currentPage()+2 }}">{{ $paginator->currentPage()+2 }}</a>
                </li>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage()-3)
                <li><span class="pagination-ellipsis">&hellip;</span></li>
            @endif
            @if($paginator->currentPage()!== $paginator->lastPage())
                <li><a href="{{$paginator->url($paginator->lastPage())}}"
                       class="pagination-link"
                       aria-label="Goto page{{$paginator->lastPage()}}">{{$paginator->lastPage()}}</a>
                </li>
            @endif
        </ul>
    </nav>
</div>
