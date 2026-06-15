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
    <h2>{{$course->title}}</h2>
    <h3>{{$course->tagline}}</h3>
    <p>{{$course->description}}</p>
    <p>{{$course->videos_count}} videos</p>
    <ul>
        @foreach($course->learnings as $learning)
            <li>{{$learning}}</li>
        @endforeach
    </ul>
    <img src="{{asset("images/$course->image_name")}}" alt="Image of the course {{$course->title}}">

    <a
        href="#"
    class="paddle_button"
    data-items='[{"priceId": "{{ $course->paddle_product_id }}", "quantity": 1}]'
    >
    Buy Now
    </a>

    <script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
    <script>
        Paddle.Environment.set("sandbox");
        Paddle.Initialize({ token: "{{ config('services.paddle.client_token') }}" });
    </script>
</body>
</html>
