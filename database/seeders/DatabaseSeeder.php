<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PersonSeeder::class,
        ]);
    }
}
