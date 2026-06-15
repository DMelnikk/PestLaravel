<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

@guest()
    <a href="{{route('login')}}">Login</a>
@else
    <form method="POST" action="{{route('logout')}}">
        @csrf
        <button type="submit">Log Out</button>
    </form>
@endguest


@foreach($courses as $course)
    <a href="{{route('pages.course-details',$course)}}">
        <h2>{{$course->title}}</h2>
    </a>
    <p>{{$course->description}}</p>
@endforeach


</body>
</html>
