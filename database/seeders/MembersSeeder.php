<?php

namespace Database\Seeders;

use App\Models\Members;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            Members::create([
                'fullname'        => fake()->name,
                'member_id'       => 'MID-' . strtoupper(Str::random(6)),
                'dob'             => fake()->date('Y-m-d', '2005-01-01'),
                'age'             => fake()->numberBetween(18, 60),
                'alter_call'      => fake()->date('Y-m-d'),
                'gender'          => fake()->randomElement(['Male', 'Female']),
                'marital_status'  => fake()->randomElement(['Single', 'Married', 'Divorced']),
                'occupation'      => fake()->jobTitle,
                'telephone'       => fake()->phoneNumber,
                'spouse'          => fake()->name,
                'children'        => fake()->numberBetween(0, 5),
                'city'            => fake()->city,
                'region'          => fake()->state,
                'house_address'   => fake()->address,
                'postal'          => fake()->postcode,
                'position'        => fake()->randomElement(['Member', 'Pastor', 'Deacon']),
                'department'      => fake()->randomElement(['Choir', 'Usher', 'Media', 'Prayer']),
                'photo'           => 'photos/dummy.jpg', // or null
                'branch_name'     => fake()->randomElement(['Main', 'East Branch', 'West Branch']),
                'branch_id'       => fake()->uuid,
            ]);
        }
    }

}
