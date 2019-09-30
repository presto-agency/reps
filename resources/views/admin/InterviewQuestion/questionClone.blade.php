{{--<div class="row" id="app2">--}}
{{--    <example-component></example-component>--}}
{{--</div>--}}
    <div class="form-group" name="add_name" id="add_name">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
{{--        @dd($answers)--}}
            <div class="table-responsive">
                <table class="table table-bordered" id="dynamic_field">
                    <tr>
                        <td><input type="text" name="answer[]" placeholder="Enter your Answer" class="form-control name_list" /></td>
                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                    </tr>
                </table>
            </div>
    </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var postURL = "<?php echo url('addmore'); ?>";
        var i=1;

        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="answer[]" placeholder="Enter your Answer" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        // function printErrorMsg (msg) {
        //     $(".print-error-msg").find("ul").html('');
        //     $(".print-error-msg").css('display','block');
        //     $.each( msg, function( key, value ) {
        //         $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        //     });
        // }
    });
</script>

