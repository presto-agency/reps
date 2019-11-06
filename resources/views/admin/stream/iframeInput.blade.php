<p>Примеры URl (afreecatv): http://play.afreecatv.com/byflash/218520058</p>
<p>Примеры URl (twitch): https://www.twitch.tv/treshapro</p>
<p>Примеры URl (goodgame): https://goodgame.ru/channel/PHombie/#autoplay</p>
@isset($streamUrlIframe)
    <iframe src="{{$streamUrlIframe}}"
            allowfullscreen="true"
            width="640"
            height="360"
            autoplay="1"
            scrolling="no"
            frameborder="0"
    ></iframe>
@endisset
