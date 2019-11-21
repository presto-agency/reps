@if ($user)
    <li class="dropdown user user-menu" style="margin-right: 20px;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            @if(auth()->user() && auth()->user()->userViewAvatars())
                <img src="{{asset($user->avatarOrDefault())}}" class="user-image"/>
            @else
                <img src="{{asset($user->avatarOrDefault())}}" class="user-image"/>
            @endif
            <span class="hidden-xs">{{ $user->name }}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="user-header">
                @if(auth()->user() && auth()->user()->userViewAvatars())
                    <img src="{{asset($user->avatarOrDefault()) }}" class="img-circle"/>
                @else
                    <img src="{{asset($user->avatarOrDefault()) }}" class="img-circle"/>
                @endif
                <p>
                    {{ $user->name }} <small>({{ $user->roles->title }})</small>
                    <small>@lang('sleeping_owl::lang.auth.since', ['date' => $user->created_at->format('h:m d.m.Y')])</small>
                </p>
            </li>
            <li class="user-footer">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> @lang('sleeping_owl::lang.auth.logout')
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
@endif
