<?php

namespace Modules\Post\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Post\Entities\Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => 10,
            'post_id' => 1,
            'content' => fake()->text(),
        ];

    }
}
