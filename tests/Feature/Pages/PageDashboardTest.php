<?php

use App\Models\Course;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;

use function Pest\Laravel\get;

it('cannot be accessed by a guest', function () {
    get(route('pages.dashboard'))
        ->assertRedirect('login');
});

it('lists purchased courses', function () {
    $user = User::factory()
        ->has(Course::factory()->count(3)->state(
            new Sequence(
                ['title' => 'Course A'],
                ['title' => 'Course B'],
                ['title' => 'Course C']
            )
        )->has(Video::factory()), 'purchasedCourses')->create();

    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText([
            'Course A',
            'Course B',
            'Course C',
        ]);
});

it('does not list other courses', function () {
    $course = Course::factory()->create();

    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertDontSee($course->title);
});

it('shows latest purchased course first', function () {
    $user = User::factory()->create();
    $firstPurchasedCourse = Course::factory()->has(Video::factory())->create();
    $lastPurchasedCourse = Course::factory()->has(Video::factory())->create();

    $user->purchasedCourses()->attach($firstPurchasedCourse, ['created_at' => Carbon::yesterday()]);
    $user->purchasedCourses()->attach($lastPurchasedCourse, ['created_at' => Carbon::now()]);

    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            $lastPurchasedCourse->title,
            $firstPurchasedCourse->title,
        ]);
});

it('includes link to product videos', function () {
    $user = User::factory()
        ->has(Course::factory()->has(Video::factory()), 'purchasedCourses')
        ->create();

    loginAsUser($user);
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Watch videos')
        ->assertSee(route('page.course-videos', [
            'course' => Course::first(),
            'video' => Course::first()->videos->first(),
        ]));
});

it('includes logout', function () {
    loginAsUser();
    get(route('pages.dashboard'))
        ->assertOk()
        ->assertSeeText('Log out')
        ->assertSee(route('logout'));
});
