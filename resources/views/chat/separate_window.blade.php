<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<style type="text/css">
	    #appchat {
	        width: 320px !important;
	    }
	</style>
</head>
<body>
<div id="appchat">
    <chat-room :auth="{{ Auth::check() ? Auth::user() : 0 }}"
         :not_user="{{ (Auth::check() && Auth::user()->email_verified_at) ? Auth::user()->isNotUser() : 0}}"/>
</div>
@include("modal.authorization")
<script src="{{ asset('js/app.js') }}" ></script>
</body>
</html>


