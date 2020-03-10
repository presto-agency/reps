$(document).ready(function () {
        const token = $('meta[name="csrf-token"]').attr('content');
        const url = $('#load_galleries-list').data('rout');

        loadGalleries('',);

        function loadGalleries(id = '',) {
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    id: id,
                    _token: token,
                },
                success: function (data) {
                    $('#load_more_galleries').remove();
                    $('#load_galleries-list').append(data);
                }
            })
        }

        $(document).on('click', '#load_more_galleries', function () {
            $('#load_more_galleries').html('<b>Загрузка...</b>');
            loadGalleries($(this).data('id'));
        });
    }
);
