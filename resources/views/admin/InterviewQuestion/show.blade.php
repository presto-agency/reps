<div class="container">
    <h4>{{$getQuestionName}}</h4>
    <br>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-group">
                @foreach($data as $item)
                    <li class="list-group-item list-group-item-info">
                        <p style="margin-top:10px">{{ $item['answer'] ." /Выбрали: " .$item['userAnswersCount'] }}</p>
                    </li>
                    <br>
                @endforeach
            </ul>
        </div>
    </div>
</div>




