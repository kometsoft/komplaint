<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@domain.com',
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Complaint::factory(10)->create();
    }
}
