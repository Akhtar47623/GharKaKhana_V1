<!DOCTYPE html>
<html>
<head>
	<title>Label</title>
</head>
<body>
	@if(!empty($menuData))
		@foreach($menuData as $m)
			<img src="{{asset('public/frontend/images/menu/'.$m->label_photo)}}">
			<p style="page-break-before: always;"></p>
		@endforeach
		
	@endif
</body>
</html>