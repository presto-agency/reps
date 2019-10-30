<div class="row">

    <div class="col-lg-3 col-6">
        <!-- small card Users-count -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$data['users'] ?? ''}}</h3>

                <p>Количество пользователей</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>

            <a href="{{url('admin\users')}}" class="small-box-footer">
                Список <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small card User Replays-count -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$data['countUser'] ?? ''}}</h3>
                <p>Количество пользовательский Replays</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-video"></i>
            </div>
            <a href="{{url('admin\replays'.'?user_replay='.$data['userId'])}}" class="small-box-footer">
                Список <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small card Gosu Replays-count -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$data['countGosu'] ?? ''}}</h3>
                <p>Количество профисиональных Replays</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-video"></i>
            </div>
            <a href="{{url('admin\replays'.'?user_replay='.$data['gosuId'])}}" class="small-box-footer">
                Список <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small card Forum Topics-count -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$data['forumTopics'] ?? ''}}</h3>
                <p>Количество Forum Topics</p>
            </div>
            <div class="icon">
                <i class="far fa-newspaper"></i>
            </div>
            <a href="{{url('admin\forum_topics')}}" class="small-box-footer">
                Список <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <!-- ./col -->
</div>
