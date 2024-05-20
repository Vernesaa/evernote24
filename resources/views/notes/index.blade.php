<!DOCTYPE html>
<html>
<head>
    <title>Notizenansicht</title>
</head>
<body>
<h1>Notizanischt</h1>
<ul>
    @foreach ($notes as $note)
        <li><a href="/notes/{{$note->id}}">{{$note->title}}</a></li>
    @endforeach
</ul>






<a href="/lists">Zurück zu den Listen</a>


</body>
</html>


