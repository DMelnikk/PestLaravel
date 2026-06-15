<?php

namespace Database\Factories;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'paddle_product_id' => $this->faker->uuid,
            'title' => $this->faker->sentence,
            'tagline' => $this->faker->sentence,
            'image_name' => 'image.png',
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'learnings' => ['Learn A', 'Learn B', 'Learn C'],
        ];
    }

    public function released(?Carbon $date = null): self
    {
        return $this->state(
            fn ($attributes) => ['released_at' => $date ?? Carbon::now()]
        );
    }
}
