<!DOCTYPE html>
<html>

{{ Counter::count(Request::path(), \Auth::check() ? \Auth::user()->id : null) }}

@include('common.head')

<body>
	@include('common.header')
	@yield('content')
	@yield('scripts')
	@include('common.footer')
</body>
</html>

