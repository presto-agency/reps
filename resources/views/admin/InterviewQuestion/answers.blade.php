<br>
<table class="table table-bordered" id="dynamic_field">
    @isset($method)
        @if($method == 'create')
            <tr id="row1">
                <td>
                    <input type="text" name="answers[]" placeholder="Вопрос"
                           minlength="1" maxlength="255" class="form-control name_list"/>
                </td>
                <td>
                    <button type="button" name="add" id="add" class="btn btn-success">+</button>
                </td>
            </tr>
        @endif
    @endisset
    @isset($method)
        @if($method == 'edit')
            @foreach($answers as  $answer)
                <tr id="row" class="dynamic-added">
                    <td>
                        <input id='{{$answer->id}}' type="text" name="answers[{{$answer->id}}]"
                               placeholder="Вопрос"
                               minlength="1" maxlength="255" class="form-control name_list"
                               value="{{$answer->answer}}"/>
                    </td>
                    <td>
                        @isset($answers)
                            @if($answersLeft)
                                {{ Form::open(['method' => 'DELETE', 'route' => ['admin.answers.delete', 'id' => $answer->id], 'name' => 'delete']) }}
                                <button class="btn btn-danger">Удалить вопрос</button>

                            @endif
                            {{ Form::close() }}
                        @endisset
                    </td>
                </tr>
            @endforeach
        @endisset
        <td>
            <button type="button" name="add" id="add" class="btn btn-success">+</button>
        </td>
    @endisset
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
                '<input type="text" name="answers[]" placeholder="Вопрос" minlength="1" maxlength="255" class="form-control name_list"/>' +
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
