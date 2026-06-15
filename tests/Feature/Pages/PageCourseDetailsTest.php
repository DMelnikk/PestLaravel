<?php

use App\Models\Course;
use App\Models\Video;

use function Pest\Laravel\get;

it('does not find unreleased course', function () {
    $course = Course::factory()->create();

    get(route('pages.course-details', $course))
        ->assertNotFound();

});

it('shows course details', function () {
    $course = Course::factory()->released()->create();

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings,
        ])
        ->assertSee("images/$course->image_name");
});

it('shows course video count', function () {
    $course = Course::factory()
        ->released()
        ->has(Video::factory()->count(3))
        ->create();

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');
});

it('includes paddle checkout button', function () {
    $course = Course::factory()
        ->released()
        ->create([
            'paddle_product_id' => 'pri_testxxxxxxxx', // v2 использует priceId, не productId
        ]);

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSee('<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>', false)
        ->assertSee('Paddle.Initialize(', false)
        ->assertSee('paddle_button', false)
        ->assertSee($course->paddle_product_id, false);
});
