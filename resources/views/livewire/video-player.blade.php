<div>
    <iframe src="https://player.vimeo.com/video/{{$video->vimeo_id}}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{$video->title}} ({{$video->getReadableDuration()}})</h3>
    <p>{{$video->description}}</p>
    @if($video->alreadyWatchedByCurrentUser())
        <button wire:click="markVideoAsNotCompleted">Mark as not Completed</button>
    @else
        <button wire:click="markVideoAsCompleted">Mark as Completed</button>
    @endif


    <ul>
        @foreach($courseVideos as $courseVideo)

            <li>
                @if($this->isCurrentVideo($courseVideo))
                    {{$courseVideo->title}}
                @else
                <a href="{{route('page.course-videos',['course' => $courseVideo->course, 'video' => $courseVideo])}}">
                    {{$courseVideo->title}}
                </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>

