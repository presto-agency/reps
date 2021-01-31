$(document).ready(function () {
    const div = $('#streamOnline');
    const divName = $('#streamOnlineName');
    const divRace = $('#streamOnlineRace');
    const divFlag = $('#streamOnlineFlag');

    $('.js-stream-selector').on('click', function () {
        const btn = $(this);
        div.prop('src', btn.data('src'));
        divFlag.prop('src', btn.data('img-flag')).show();
        divRace.prop('src', btn.data('img-race')).show();
        divFlag.prop('title', btn.data('name-flag'));
        divRace.prop('title', btn.data('title-race'));
        divName.prop('title', btn.data('stream-title'));
        divName.text(btn.data('stream-title'));
    });
});
