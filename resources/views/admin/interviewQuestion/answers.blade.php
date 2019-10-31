<div id="input-text"></div>


<button type="button" name="add" id="add" class=" btn btn-success">+</button>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        let i = 1;
        $('#add').on('click', function () {
            i++;
            var inputField = $('.form-group').clone();
            $('#input-text').html(inputField);
            console.log(i);
            // $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="answer[]" placeholder="Ответ на вопрос"   class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        // $(document).on('click', '.btn_remove', function () {
        //     var button_id = $(this).attr("id");
        //     $('#row' + button_id + '').remove();
        // });
    });
</script>
{{--<script type="text/javascript">--}}
{{--    $('.download').click(function () {--}}
{{--        let id = $(this).data('id');--}}
{{--        let token = $('meta[name="csrf-token"]').attr('content');--}}
{{--        let url = $(this).data('url');--}}
{{--        $.ajax({--}}
{{--            method: 'POST',--}}
{{--            url: url,--}}
{{--            dataType: 'json',--}}
{{--            async: false,--}}
{{--            data: {--}}
{{--                _token: token,--}}
{{--                id: id,--}}
{{--            },--}}
{{--            success: function (data) {--}}
{{--                $('#downloadCount').html(data.downloaded);--}}
{{--                console.log(data.downloaded);--}}
{{--            },--}}
{{--            error: function (request, status, error) {--}}
{{--                console.log('code: ' + request.status + "\n" + 'message: ' + request.responseText + "\n" + 'error: ' + error);--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
