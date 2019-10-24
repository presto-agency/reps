@if ($user)
    <li class="dropdown user user-menu" style="margin-right: 20px;">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            @if(file_exists($user->avatar) === true)
                <img src="{{asset($user->avatar)}}"
                     class="user-image"/>
                <span class="hidden-xs">{{ $user->name }}</span>
            @else
                <img src="{{asset($user->avatar_url_or_blank) }}"
                     class="user-image"/>
                <span class="hidden-xs">{{ $user->name }}</span>
            @endif
        </a>
        <ul class="dropdown-menu">
            <li class="user-header">
                <img src="{{asset($user->avatar_url_or_blank) }}" class="img-circle"/>
                <p>
                    {{ $user->name }} <small>({{ $user->roles->title }})</small>
                    <small>@lang('sleeping_owl::lang.auth.since', ['date' => $user->created_at->format('d.m.Y')])</small>
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
