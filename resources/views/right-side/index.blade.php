@isset($voteRight)
    @if($voteRight)
        @include('components.interview')
    @endif
@endisset
@include('right-side.components.top-and-user')
