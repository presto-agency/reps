<section class="streams_list stream-list-wrapper">
    <div class="widget-wrapper">
        <div class="streams_list_container">
            @foreach($streamList as $item)
                <div class="widget-stream-lists">
                    <button class="streamEvent" id="{{$item['id']}}" data-src="{{$item['streamUrl']}}">
                        <img class="margin-left-5" src="{{asset($item['countryFlag25x20'])}}" alt="CountriesFlag">
                        <img class="margin-left-5"
                             src="{{asset($item['racesTitle'])}}" alt="Races">
                        <span class="color-blue">{{$item['streamTitle']}}</span>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</section>
<script>
    $('.streamEvent').click(function () {
        $('#streamOnline').attr('src', $(this).data('src'));
    });
</script>
