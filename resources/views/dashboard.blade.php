<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <ul>
                    @foreach($purchasedCourses as $purchasedCourse)
                        <li>
                            <p>{{$purchasedCourse->title}}</p>
                            <a href="{{route('page.course-videos',['course' => $purchasedCourse, 'video' => $purchasedCourse->videos->first()])}}">Watch videos</a>
                        </li>
                    @endforeach
                </ul>
                @guest()
                    <a href="{{route('login')}}">Login</a>
                @else
                    <a href="{{route('logout')}}">Log out</a>
                @endguest
            </div>
        </div>
    </div>
</x-app-layout>
