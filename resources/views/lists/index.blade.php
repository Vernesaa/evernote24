<!DOCTYPE html>
<html>
<head>
    <title>Evernote</title>
</head>
<body>
<h1>Willkommen bei Evernote</h1>

<ul>
    @foreach ($lists as $list)
        <li><a  href="/lists/{{$list->id}}">{{$list->name}}</a></li>
    @endforeach
</ul>

</body>
</html>
