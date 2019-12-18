<div class="form-group">
    <label for="video_iframe_url" class="night_text">{{__('Вставте URL для Video Iframe')}}</label>
    <input id="video_iframe_url" name="video_iframe_url" class="form-control night_input" maxlength="500"
           placeholder="{{__('Вставте URL для Video Iframe')}}"
           data-url="{{route('set.iframe')}}"
           value="">
</div>
<iframe id="video_iframe_set" class="d-none"></iframe>
<div id="video_iframe_error" class="alert alert-danger d-none"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    /*** ajax-video-iframe ***/
    $(document).ready(function () {
        if ($('#video_iframe_url').val()) {
            if (localStorage.success === 'true') {
                updateDataIfSuccess()
            }
            if (localStorage.success === 'false') {
                updateDataIfError()
            }
            if (localStorage.success !== 'false' && localStorage.success !== 'true') {
                refreshAllData();
            }
        } else {
            refreshAllData();
        }

        //setup before functions
        let typingTimer;                //timer identifier
        let doneTypingInterval = 1500;  //time in ms (1.5 seconds)
        //on keyup, start the countdown
        $('#video_iframe_url').keyup(function () {
            clearTimeout(typingTimer);
            if ($('#video_iframe_url').val()) {
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            } else {
                refreshAllData();
            }
        });

        //user is "finished typing," do something
        function doneTyping() {
            const token = $('meta[name="csrf-token"]').attr('content');
            let video_iframe_url = $('#video_iframe_url').val();
            let url = $('#video_iframe_url').data('url');
            sendAjax(token, video_iframe_url, url)
        }

        function sendAjax(token, video_iframe_url, url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: token,
                    video_iframe_url: video_iframe_url,
                },
                success: function (data) {
                    updateLocalStorage(data.success, data.message);
                    updateDataIfSuccess()
                },
                error: function (data) {
                    updateLocalStorage(data.responseJSON.success, data.responseJSON.message);
                    updateDataIfError();
                }
            });
        }

        function updateDataIfSuccess() {
            $('#src_iframe').val(localStorage.message);
            $('#video_iframe_set').removeClass('d-none').attr('src', localStorage.message);
            $("#video_iframe_error").addClass('d-none').html('');
        }

        function updateDataIfError() {
            $('#src_iframe').val('');
            $('#video_iframe_set').addClass('d-none').attr('src', '');
            $("#video_iframe_error").removeClass('d-none').html(localStorage.message);
        }

        function updateLocalStorage(success, message) {
            delete localStorage.success;
            delete localStorage.message;
            localStorage.success = success;
            localStorage.message = message;
        }

        function refreshAllData() {
            delete localStorage.success;
            delete localStorage.message;
            $('#src_iframe').val('');
            $('#video_iframe_set').addClass('d-none').attr('src', '');
            $("#video_iframe_error").addClass('d-none').html('');
        }
    });
    /*** ajax-video-iframe ***/
</script>