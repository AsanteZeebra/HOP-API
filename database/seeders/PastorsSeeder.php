<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pastor;
use Illuminate\Support\Str;

class PastorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       for ($i = 0; $i < 100; $i++) {
            Pastor::create([
                'fullname'           => fake()->name,
            'pastor_code'        => 'HPS-' . strtoupper(Str::random(10)),
            'title'              => fake()->randomElement(['Rev.', 'Pastor', 'Evangelist']),
            'dob'                => fake()->date('Y-m-d', now()->subYears(60)),
            'marital_status'     => fake()->randomElement(['Single', 'Married', 'Divorced']),
            'spouse'             => fake()->optional()->name,
            'children'           => fake()->optional()->words(rand(1, 3), true), // e.g. "John, Mary"
            'telephone'          => fake()->phoneNumber,
            'from_date'          => fake()->dateTimeBetween('-10 years', '-1 years')->format('Y-m-d'),
            'to_date'            => fake()->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'next_of_kin'        => fake()->name,
            'emergency_contact'  => fake()->phoneNumber,
            'created_by'         => 'Seeder',
            'status'             => fake()->randomElement(['active', 'retired', 'transferred']),
            'photo'              => 'photos/dummy.jpg',

            ]);
        }
    }
}
