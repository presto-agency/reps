@include('layouts.components.header.components.navigation-panel')
@include('components.mobile_menu')

@guest
    @include('modal.registration')
    @include('modal.authorization')
@endguest

@include('modal.ban_message')
