$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');
    const url = $('#load_forum_sections').data('rout');

    loadForumSections('',);

    function loadForumSections(id = "",) {
        $.ajax({
            url: url,
            method: "POST",
            data: {
                id: id,
                _token: token
            },
            success: function (data) {
                $('#load_more_forum_sections').remove();
                $('#load_forum_sections').append(data);
            }
        })
    }

    $(document).on('click', '#load_more_forum_sections', function () {
        $('#load_more_forum_sections').html('<b>Загрузка...</b>');
        loadForumSections($(this).data('id'));
    });
});
