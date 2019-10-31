<div class="form-group" name="add_name" id="add_name">
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul>hi</ul>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="dynamic_field">
            @if($edit)
                <tr>
                    <td>
                        <input type="text" name="answer[]" placeholder="Ответ на вопрос"
                               minlength="1" maxlength="255" class="form-control name_list"/>
                    </td>
                    <td>
                        <button type="button" name="add" id="add" class="btn btn-success">+</button>
                    </td>
                </tr>
            @else
                @if(!$answers->isEmpty())
                    @foreach($answers as  $answer)
                        <tr id="row" class="dynamic-added">
                            <td>
                                <input id='{{$answer->id}}' type="text" name="answer[{{$answer->id}}]"
                                       minlength="1" maxlength="10" placeholder="Ответ на вопрос"
                                       class="form-control name_list" value="{{$answer->answer}}"/>
                            </td>
                            <td>
                                @if($questionsLeft)
                                    {{ Form::open(['method' => 'DELETE', 'route' => ['admin.answers.delete', 'id' => $answer->id], 'name' => 'delete']) }}
                                    <button class="btn btn-danger">Удалить вопрос</button>
                                @endif
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                @endif
                <td>
                    <button type="button" name="add" id="add" class="btn btn-success">+</button>
                </td>
            @endif
        </table>
    </div>
</div>
{{--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        {{--var postURL = "<?php echo url('addmore'); ?>";--}}
        var i = 1;
        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="answer[]" placeholder="Ответ на вопрос"   class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>
