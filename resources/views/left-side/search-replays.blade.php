<div class="search border_ border_shadow">
    <div class="search__title">
        <svg class="title__icon" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
             xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 512 512">
            <path
                d="M495,466.2L377.2,348.4c29.2-35.6,46.8-81.2,46.8-130.9C424,103.5,331.5,11,217.5,11C103.4,11,11,103.5,11,217.5   S103.4,424,217.5,424c49.7,0,95.2-17.5,130.8-46.7L466.1,495c8,8,20.9,8,28.9,0C503,487.1,503,474.1,495,466.2z M217.5,382.9   C126.2,382.9,52,308.7,52,217.5S126.2,52,217.5,52C308.7,52,383,126.3,383,217.5S308.7,382.9,217.5,382.9z"/>
        </svg>
        <p class="title__text">{{__('Поиск реплеев')}}</p>
    </div>
    <div class="search__body night_modal">
        <form method="GET" action="{{route('replay.only.search')}}">
            <label class="body__name" for="text">
                <input class="night_input" id="text" placeholder="{{__('Имя / Описание...')}}" type="text" name="text"
                       maxlength="255"
                       value="{{old('text')}}">
            </label>

            <label class="body__country-winner" for="first_country_id">{{__('Первая страна:')}}
                <select class="night_input" id="first_country_id" name="first_country_id">
                    <option value="">Все</option>
                    @foreach($searchCountry as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </label>

            <label class="body__country-loser" for="second_country_id">{{__('Вторая страна:')}}
                <select class="night_input" id="second_country_id" name="second_country_id">
                    <option value="">{{__('Все')}}</option>
                    @foreach($searchCountry as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </label>

            <label class="body__winning-race" for="first_race">Первая раса:
                <select class="night_input" id="first_race" name="first_race">
                    <option value="">Все</option>
                    @foreach($searchRace as $item)
                        <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                </select>
            </label>

            <label class="body__losing-race" for="second_race">Вторая раса:
                <select class="night_input" id="second_race" name="second_race">
                    <option value="">Все</option>
                    @foreach($searchRace as $item)
                        <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                </select>
            </label>

            <label class="body__map" for="map_id">Карта:
                <select class="night_input" id="map_id" name="map_id">
                    <option value="">Все</option>
                    @foreach($searchMap as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </label>
            <label class="body__type" for="type_id">Тип:
                <select class="night_input" id="type_id" name="type_id">
                    <option value="">Все</option>
                    @foreach($searchType as $item)
                        <option value="{{$item->id}}">{{$item->title}}</option>
                    @endforeach
                </select>
            </label>
            <label class="body__sorting" for="user_replay">Сортировка:
                <select class="night_input" id="user_replay" name="user_replay">
                    <option value="">Все</option>
                    @foreach($searchType2 as $key => $item)
                        <option value="{{$key}}">{{$item}}</option>
                    @endforeach
                </select>
            </label>
            <div class="body__button-search">
                <button class="button button__download-more">
                    Поиск
                </button>
            </div>

        </form>
    </div>

</div>
