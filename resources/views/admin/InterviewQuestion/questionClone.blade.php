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
    $i = 0;
    $fullstring = "$getUrl";
    $getId = get_string_between($fullstring, '/admin/interview_questions/', "/$getMethod");
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
                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                    </td>
                </tr>
            @endif
            @if($getMethod == 'edit')
                @foreach($answers as $key => $answer)
                    @if($getId == $answer->question_id)
                        <tr id="row" class="dynamic-added">
                            <td>
                                <input id='dynamicInput' type="text" name="answer[{{$answer->id}}]" placeholder="Enter your Answer"
                                       class="form-control name_list" value="{{$answer->answer}}"/>
                            </td>
                            <td>
                                <button class="deleteRecord" data-id="{{ $answer->id }}"
                                        data-token="{{ csrf_token() }}">Delete Task
                                </button>
                            </td>
                        </tr>

                    @endif
                @endforeach

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
        $(".deleteRecord").click(function () {
            var id = $(this).data("id");
            var token = $(this).data("token");
            var url = "{{url("admin/interviewvariantanswers/destroy/")}}";
            $('#dynamicInput').val('DELETE');
            $.ajax(
                {
                    url: url+"/" + id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function () {
                        console.log("it Works");
                    }
                });
        });
    });
</script>
