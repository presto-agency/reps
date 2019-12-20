@if(isset($banners) && $banners->isNotEmpty())
    <section class="banner border_shadow">
        <div class="wrapper">
            <div class="title_block">
                <p class="title_text">{{__('Рекомендуем')}}</p>
            </div>
            @foreach($banners as $item)
                <div class="block_content">
                    <a href="{{$item->url_redirect}}" title="{{$item->title}}">
                        <img src="{{asset($item->image)}}" alt="banner"/>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endisset
@isset($voteRight)
    @if($voteRight)
        @include('components.interview')
    @endif
@endisset
@include('right-side.components.top-and-user')
