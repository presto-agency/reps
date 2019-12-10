<div class="container">
    <div class="col-md-8 offset-md-2">
        <h1>{{__('Новый Email')}}</h1>
        <hr/>
        @if (session('email-send'))
            <div class="alert alert-info" role="alert">
                {{ session('email-send')}}
            </div>
        @endif
        @if (session('email-send-error'))
            <div class="alert alert-danger" role="alert">
                {{ session('email-send-error')}}
            </div>
        @endif

        {!! Form::open(['method' => 'POST', 'route' => ['admin.user.email-send.send']]) !!}
        <div class="form-group row required">
            {!! Form::label("to_email","Кому email",["class"=>"col-form-label col-md-3 col-lg-2"]) !!}
            <div class="col-md-8">
                {!! Form::text("to_email",old('to_email',$user->email),["class"=>"form-control".($errors->has('to_email')?" is-invalid":""),"autofocus",'placeholder'=>'Кому email']) !!}
                {!! $errors->first('to_email','<span class="invalid-feedback">:message</span>') !!}
            </div>
        </div>
        <div class="form-group row required">
            {!! Form::label("subject","Тема",["class"=>"col-form-label col-md-3 col-lg-2"]) !!}
            <div class="col-md-8">
                {!! Form::text("subject",old('subject'),["class"=>"form-control".($errors->has('subject')?" is-invalid":""),'placeholder'=>'Тема']) !!}
                {!! $errors->first('subject','<span class="invalid-feedback">:message</span>') !!}
            </div>
        </div>
        <div class="form-group row required">
            {!! Form::label("message","Сообщение",["class"=>"col-form-label col-md-3 col-lg-2"]) !!}
            <div class="col-md-8">
                {!! Form::textarea("message",old('message'),["class"=>"form-control".($errors->has('message')?" is-invalid":""),'placeholder'=>'Сообщение']) !!}
                {!! $errors->first('message','<span class="invalid-feedback">:message</span>') !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 col-lg-2"></div>
            <div class="col-md-4">
                {!! Form::button("Отправить",["type" => "submit","class"=>"btn btn-primary"])!!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
