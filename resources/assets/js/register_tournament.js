$('#tournamentRegister').click(function () {
    const token = $('meta[name="csrf-token"]').attr('content');
    let description = $('#description').val();
    if (description) {
        $.ajax({
            url: $(this).data('rout'),
            method: "POST",
            data: {
                _token: token,
                description: description,
                tourneyId: $(this).data('id'),
            },
            success: function (data) {
                if (data.success === true) {
                    $("#tournamentRegister").remove();
                    $("#description_success").removeClass('d-none').html(data.message);
                }
            },
            errors: function (data) {
                if (data.success === false) {
                    $("#tournamentRegister").remove();
                    $("#description_error").removeClass('d-none').html(data.message);
                }
                if (data.responseJSON && data.responseJSON.errors) {
                    if (data.responseJSON.errors.description) {
                        $("#description_error").removeClass('d-none').html(data.responseJSON.errors.description);
                    }
                    if (data.responseJSON.errors.tourneyId) {
                        $("#description_error").removeClass('d-none').html(data.responseJSON.errors.tourneyId);
                    }
                }

            }
        })
    }
});
