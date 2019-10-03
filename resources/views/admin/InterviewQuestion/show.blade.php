<div class="container">
    <h4>{{$interviewQuestion->question}}</h4>
    <br>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-group">
                @foreach($interviewVariantAnswers as $answer)
                    <li class="list-group-item list-group-item-info">
                        <p style="margin-top:10px">{{$answer->answer}}/Выбрали:{{$answer->userAnswers->count()}}</p>
                    </li>
                    <br>
                @endforeach
            </ul>
        </div>
    </div>
</div>




