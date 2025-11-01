    <div class="d-flex bg-white align-items-center justify-content-between border-primary border-1 border-bottom my-3 py-2 px-2">
    <h6 class="bold fs-7">{{ $title }}</h6>
    @if($link_title)
    <a href="{{ $link }}" class="btn btn-sm btn-primary">{{ $link_title }}</a>
@endif
</div>

