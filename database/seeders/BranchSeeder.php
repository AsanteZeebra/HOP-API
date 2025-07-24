<?php

namespace Database\Seeders;

use App\Models\Branches;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            Branches::create([
                'branch_name' => 'Branch ' . ($i + 1),
                'branch_id'   => 'BID-' . strtoupper(Str::random(5)),
                'type'        => fake()->randomElement(['main', 'sub']),
                'region'      => fake()->state,
                'district'    => fake()->citySuffix,
                'town'        => fake()->city,
                'area_head'   => fake()->name,
                'telephone'   => fake()->phoneNumber,
                'email'       => fake()->unique()->safeEmail,
                'address'     => fake()->address,
                'status'      => fake()->randomElement(['active', 'inactive']),
            ]);
        }

    }
}
