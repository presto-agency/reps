$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');
    const url = $('#load_forum_sections_show').data('rout');

    loadForumSectionsShow('');

    function loadForumSectionsShow(id = '') {
        $.ajax({
            url: url,
            method: "POST",
            data: {
                id: id,
                _token: token,
            },
            success: function (data) {
                $('#load_forum_sections').remove();
                $('#load_forum_sections_show').append(data);
            }
        })
    }

    $(document).on('click', '#load_forum_sections', function () {
        $('#load_forum_sections').html('<b>Загрузка...</b>');
        loadForumSectionsShow($(this).data('id'));
    });
});
