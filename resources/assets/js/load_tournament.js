$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');
    const url = $('#load_tournament-list').data('rout');
    loadTournament('');

    function loadTournament(id = '') {
        $.ajax({
            url: url,
            method: "POST",
            data: {
                id: id,
                _token: token
            },
            success: function (data) {
                $('#load_more-tournament').remove();
                $('#load_tournament-list').append(data);
            }
        })
    }

    $(document).on('click', '#load_more-tournament', function () {
        $('#load_more-tournament').html('<b>Загрузка...</b>');
        loadTournament($(this).data('id'));
    });
});
