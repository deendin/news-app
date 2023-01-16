<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->text(20),
            'content' => $this->faker->text,
        ];
    }

    /**
     * Older news records
     * 
     * Default value to flag older records is set to 14.
     * 
     * @todo - put this value in a config file?
     */
    public function olderNews()
    {
        return $this->state( function(array $attributes){
            return [
                'created_at' => now()->subDays(14)->setTime(0, 0, 0)->toDateTimeString()
            ];
        });
    }
}
