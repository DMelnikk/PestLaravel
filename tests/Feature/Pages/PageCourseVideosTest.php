<?php


use App\Livewire\VideoPlayer;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;
use function Pest\Laravel\get;

it('cannot be accessed by guest', function () {
    $course = Course::factory()->has(Video::factory())->create();

    get(route('page.course-videos', ['course' => $course, 'video' => $course->videos->first()]))
        ->assertRedirect(route('login'));
});

it('includes video player', function () {
    $course = Course::factory()
        ->has(Video::factory())
        ->create();
    loginAsUser();
    get(route('page.course-videos', ['course' => $course, 'video' => $course->videos->first()]))
        ->assertOk()
        ->assertSeeLivewire(VideoPlayer::class);
});


it('shows first course video by default', function () {
    $course = Course::factory()
        ->has(Video::factory())
        ->create();
    loginAsUser();
    get(route('page.course-videos', ['course' => $course, 'video' => $course->videos->first()]))
        ->assertOk()
        ->assertSeeText("<h3>{$course->videos()->first()->title}</h3>",false);
});


it('shows provided course video', function () {
    $course = Course::factory()
        ->has(
            Video::factory()
                ->count(2)
                ->sequence(
                    ['title' => 'First video'],
                    ['title' => 'Second video'],
                )

        )
        ->create();
    loginAsUser();
    get(route('page.course-videos',[
        'course'=>$course,
        'video' => $course->videos()->orderByDesc('id')->first()]
    ))
        ->assertOk()
        ->assertSeeText('Second video');
});
