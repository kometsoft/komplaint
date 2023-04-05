<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Action>
 */
class ActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'complaint_id' => \App\Models\Complaint::pluck('id')->random(),
            'description' => fake()->sentence(),
            'status' => fake()->randomElement(['In Progress', 'Completed', 'Pending']),
            'created_by' => \App\Models\User::pluck('id')->random(),
        ];
    }
}
