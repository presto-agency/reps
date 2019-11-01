@isset($voteRight)
    @if($voteRight)
        @include('components.vote')
    @endif
@endisset
@include('right-side.components.top-and-user')
