<br>
<table class="table table-bordered" id="dynamic_field">
    @if($edit)
        <tr id="row1">
            <td>
                <input type="text" name="answer[]" placeholder="Вопрос"
                       minlength="1" maxlength="255" class="form-control name_list"/>
            </td>
            <td>
                <button type="button" name="add" id="add" class="btn btn-success">+</button>
            </td>
        </tr>
    @else
    @endif
</table>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        let i = 1;
        $('#add').on('click', function () {
            i++;
            console.log(i);
            $('#dynamic_field').append(
                '<tr id="row' + i + '" class="dynamic-added">' +
                '<td>' +
                '<input type="text" name="answer[]" placeholder="Вопрос" minlength="1" maxlength="255" class="form-control name_list"/>' +
                '</td>' +
                '<td>' +
                '<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button>' +
                '</td>' +
                '</tr>');

        });
        $(document).on('click', '.btn_remove', function () {
            let button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>
