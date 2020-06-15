$(document).ready(function () {
    const div = $('#streamOnline');
    const divName = $('#streamOnlineName');
    const divRace = $('#streamOnlineRace');
    const divFlag = $('#streamOnlineFlag');
    let element = document.getElementById("1");
    div.attr('src', element.getAttribute('data-src'));
    divFlag.attr('src', element.getAttribute('data-img-flag'));
    divFlag.attr('title', element.getAttribute('data-name-flag'));
    divRace.attr('src', element.getAttribute('data-img-race'));
    divRace.attr('title', element.getAttribute('data-title-race'));
    divName.attr('title', element.getAttribute('data-stream-title'));
    divName.text(element.getAttribute('data-stream-title'));

    $('.streamEvent').click(function () {
        div.attr('src', $(this).data('src'));
        divFlag.attr('src', $(this).data('img-flag'));
        divFlag.attr('title', $(this).data('name-flag'));
        divRace.attr('src', $(this).data('img-race'));
        divRace.attr('title', $(this).data('title-race'));
        divName.attr('title', $(this).data('stream-title'));
        divName.text($(this).data('stream-title'));
    });
});
