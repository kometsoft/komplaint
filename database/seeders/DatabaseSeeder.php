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
        $this->call([
            \Database\Seeders\ActionStatusSeeder::class,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@domain.com',
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Complaint::factory(200)->create();
        \App\Models\Action::factory(1000)->create();
    }
}
