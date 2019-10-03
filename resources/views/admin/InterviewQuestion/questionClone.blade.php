@php
    $getUrl = parse_url(Request::url(), PHP_URL_PATH);
    $urlFrag = explode('/', $getUrl);
    $getMethod = end($urlFrag);

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
    $getId = get_string_between($getUrl, '/admin/interview_questions/', "/$getMethod");


@endphp
<div class="form-group" name="add_name" id="add_name">
    <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="dynamic_field">

            @if($getMethod == 'create')
                <tr>
                    <td>
                        <input type="text" name="answer[]" placeholder="Enter your Answer"
                               class="form-control name_list"/>
                    </td>
                    <td>
                        <button type="button" name="add" id="add" class="btn btn-success">+</button>
                    </td>
                </tr>
            @endif
            @if($getMethod == 'edit')
                @foreach($answers as $key => $answer)
                    <tr id="row" class="dynamic-added">
                        @if($getId == $answer->question_id)
                            <td>
                                <input id='{{$answer->id}}' type="text" name="answer[{{$answer->id}}]"
                                       placeholder="Enter your Answer"
                                       class="form-control name_list" value="{{$answer->answer}}"/>
                            </td>
                            <td>
                                @if(count($answers->where('question_id',$getId)) > 1)
                                    {{ Form::open(['method' => 'DELETE', 'route' => ['admin.answers.delete', 'id' => $answer->id], 'name' => 'delete']) }}
                                    <button class="btn btn-danger">Delete Task</button>
                                @endif
                                {{ Form::close() }}
                            </td>

                        @endif
                    </tr>
                @endforeach
                <td>
                    <button type="button" name="add" id="add" class="btn btn-success">+</button>
                </td>
            @endif
        </table>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var postURL = "<?php echo url('addmore'); ?>";
        var i = 1;

        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="answer[]" placeholder="Enter your Answer" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
</script>
