<div class="container">
    @if(!empty($data->question))
        <h4>{{$data->question}}</h4>
    @endif
    <br>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-group">
                @if($data->answers->isNotEmpty())
                    @foreach($data->answers as $item)
                        <li class="list-group-item list-group-item-info">
                            <p style="margin-top:10px">{{ $item->answer ." /Выбрали: " .$item->users_count }}</p>
                        </li>
                        <br>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>




