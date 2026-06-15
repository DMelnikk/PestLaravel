<?php

use App\Models\Course;
use Carbon\Carbon;


use function Pest\Laravel\get;


it('shows courses overview', function () {
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    get(route('pages.home'))
        ->assertSeeText([
            $firstCourse->title,
            $firstCourse->description,
            $secondCourse->title,
            $secondCourse->description,
            $thirdCourse->title,
            $thirdCourse->description,
        ]);
});

it('show only released courses', function () {
    $releasedCourse = Course::factory()->released()->create();
    $notReleasedCourse = Course::factory()->create(['title' => 'Course B']);

    get(route('pages.home'))
        ->assertSeeText($releasedCourse->title)
        ->assertDontSeeText($notReleasedCourse->title);
});

it('shows courses by released date', function () {
    $releasedCourse = Course::factory()->released(Carbon::yesterday(1))->create();
    $newestReleasedCourse = Course::factory()->released()->create();

    get(route('pages.home'))
        ->assertSeeTextInOrder([
            $newestReleasedCourse->title,
            $releasedCourse->title,
        ]);
});

it('includes login if not logged in', function () {
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Login')
        ->assertSee(route('login'));
});


it('includes logout if logged in', function () {
    loginAsUser();
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeText('Log Out')
        ->assertSee(route('logout'));
});

it('includes courses links', function () {
    loginAsUser();
    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $thirdCourse = Course::factory()->released()->create();

    get(route('pages.home'))
        ->assertOk()
        ->assertSee(route('pages.course-details', $firstCourse), false)
        ->assertSee(route('pages.course-details', $secondCourse), false)
        ->assertSee(route('pages.course-details', $thirdCourse), false)
        ->assertSee(route('logout'), false);
});
