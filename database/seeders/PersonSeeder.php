<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use Faker\Factory as Faker;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        $locations = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose'];

        for ($i = 0; $i < 100; $i++) {
            $pictures = [];
            for ($j = 0; $j < rand(3, 6); $j++) {
                $pictures[] = $faker->imageUrl(640, 480, 'people', true);
            }

            Person::create([
                'name' => $faker->name(),
                'age' => $faker->numberBetween(18, 45),
                'pictures' => $pictures,
                'location' => $faker->randomElement($locations),
            ]);
        }
    }
}
