<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplaintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('complaint_types')->insert([
            ['name' => 'Portal'],
            ['name' => 'Intranet'],
            ['name' => 'HRMIS'],
        ]);
    }
}
