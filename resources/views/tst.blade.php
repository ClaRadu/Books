<!DOCTYPE html>
<html>
	<head>
		<title>Testing shit..</title>
	</head>
	<body>
		<p>Data below:</p>
		<p>Title: {{ $title }}</p>
		<p>Publisher id: {{ $publisher_id }}</p>
		<p>Author id: {{ $author_id }}</p>
		<p>List of authors: {{ $authors }}</p>
		<br/>
		@foreach($list as $l)
			<p>Element: {{ $l }}</p>
			<p>isPositive: {{ (strval($l)>0) }}</p>
		@endforeach
	</body>
</html>
