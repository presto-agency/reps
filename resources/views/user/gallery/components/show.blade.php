<div class="gallery-detail">
    <div class="gallery-detail__title">
        <svg class="title__icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 512 512" xml:space="preserve">
            <path d="M437.019,74.98C388.667,26.629,324.38,0,256,0C187.619,0,123.331,26.629,74.98,74.98C26.628,123.332,0,187.62,0,256
                s26.628,132.667,74.98,181.019C123.332,485.371,187.619,512,256,512c68.38,0,132.667-26.629,181.019-74.981
                C485.371,388.667,512,324.38,512,256S485.371,123.333,437.019,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
                s226,101.383,226,226S380.617,482,256,482z"/>
            <path d="M378.305,173.859c-5.857-5.856-15.355-5.856-21.212,0.001L224.634,306.319l-69.727-69.727
                c-5.857-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213l80.333,80.333c2.929,2.929,6.768,4.393,10.606,4.393
                c3.838,0,7.678-1.465,10.606-4.393l143.066-143.066C384.163,189.215,384.163,179.717,378.305,173.859z"/>
        </svg>
        <p class="title__text">Галерея</p>
    </div>
    @isset($userImage)
        <div class="gallery-detail__body">
            <div class="body__items">
                <div class="items__title">
                    <p>{{$userImage->sign}}</p>
                </div>
                <div class="items__rating">
                    @php
                            $modal = (!Auth::guest() && $userImage->user_id == Auth::user()->id) ?'#no-rating':'#vote-modal';
                        @endphp
                    <a href="#vote-modal" class="rating__like positive-vote vote-replay-up" data-toggle="modal" data-rating="1"
                       data-route="{{route('gallery.set_rating',['id'=>$userImage->id])}}">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                             y="0px" viewBox="0 0 512 512" xml:space="preserve">
		                    <path d="M83.6,167.3H16.7C7.5,167.3,0,174.7,0,184v300.9c0,9.2,7.5,16.7,16.7,16.7h66.9c9.2,0,16.7-7.5,16.7-16.7V184
			                    C100.3,174.7,92.8,167.3,83.6,167.3z"></path>
                            <path d="M470.3,167.3c-2.7-0.5-128.7,0-128.7,0l17.6-48c12.1-33.2,4.3-83.8-29.4-101.8c-11-5.9-26.3-8.8-38.7-5.7
                            c-7.1,1.8-13.3,6.5-17,12.8c-4.3,7.2-3.8,15.7-5.4,23.7c-3.9,20.3-13.5,39.7-28.4,54.2c-26,25.3-106.6,98.3-106.6,98.3v267.5
                            h278.6c37.6,0,62.2-42,43.7-74.7c22.1-14.2,29.7-44,16.7-66.9c22.1-14.2,29.7-44,16.7-66.9C527.6,235.2,514.8,174.8,470.3,167.3z"></path>
                    </svg>
                        <span>{{$userImage->positive_count}}</span>
                    </a>
                    <a href="#vote-modal" class="rating__dislike negative-vote vote-replay-down" data-toggle="modal" data-rating="-1"
                       data-route="{{route('gallery.set_rating',['id'=>$userImage->id])}}">
                        <svg viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M27.8534 99.2646H9.57079C7.05735 99.2646 5 97.2177 5 94.6941V12.4218C5 9.89933 7.04832 7.85183 9.57079 7.85183H27.8534C30.3759 7.85183 32.4242 9.89961 32.4242 12.4218V94.6941C32.4242 97.2177 30.3666 99.2646 27.8534 99.2646Z"/>
                            <path
                                    d="M133.587 99.2662C132.851 99.3909 98.3852 99.2662 98.3852 99.2662L103.199 112.4C106.521 121.471 104.37 135.321 95.1537 140.246C92.1527 141.849 87.9598 142.654 84.5793 141.803C82.6406 141.316 80.9368 140.032 79.9213 138.312C78.7534 136.335 78.874 134.026 78.4581 131.833C77.4034 126.271 74.7752 120.982 70.705 117.013C63.6088 110.092 41.5645 90.1252 41.5645 90.1252V16.9942H117.742C128.021 16.9882 134.758 28.4671 129.688 37.4334C135.731 41.3039 137.798 49.4565 134.259 55.716C140.302 59.5865 142.369 67.7391 138.83 73.9986C149.257 80.6768 145.771 97.2056 133.587 99.2662Z"/>
                        </svg>
                        <span>{{$userImage->negative_count}}</span>
                    </a>
                </div>
                <div class="items__reputation-button">
                    <a href="{{route('gallery.get_rating',['id' => $userImage->id])}}">рейтинг лист</a>
                </div>
                @isset($routCheck)
                    @if($routCheck)
                        <div class="items__slide-button">
                            @isset($previous)
                                <a href="{{route('galleries.show',['gallery' => $previous])}}">
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            @endisset
                            @isset($next)
                                <a href="{{route('galleries.show',['gallery' => $next])}}">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            @endisset
                        </div>
                    @else
                        <div class="items__slide-button">
                            @isset($previous)
                                <a href="{{route('user-gallery.show',['id'=> $userImage->user_id,'user_gallery'=> $previous])}}">
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            @endisset
                            @isset($next)
                                <a href="{{route('user-gallery.show',['id'=> $userImage->user_id,'user_gallery'=> $next])}}">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            @endisset
                        </div>
                    @endif
                @endisset
            </div>
            <div class="body__img">
                @if(!empty($userImage->picture) && checkFile::checkFileExists($userImage->picture))
                    <img src="{{asset($userImage->picture)}}" alt="image">
                @else
                    <img src="{{asset($userImage->defaultGallery())}}" alt="image">
                @endif
            </div>
        </div>
    @endisset
</div>
