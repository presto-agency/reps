<div class="form-group">
    <label for="video_iframe_url" class="night_text">{{__('Вставить URL для Video Iframe')}}</label>
    <input id="video_iframe_url" name="video_iframe_url" class="form-control night_input" maxlength="500"
           placeholder="{{__('Вставить URL для Video Iframe')}}"
           data-url="{{route('set.iframe')}}"
           value="">
</div>
<iframe id="video_iframe_set" class="d-none" src="" width="100%" height="340" frameborder="0" scrolling="no"
        allowfullscreen></iframe>
<div id="video_iframe_error" class="alert alert-danger d-none"></div>
<script type="text/javascript" src="{{mix('js/replay_iframe_edit.js')}}" defer></script>
