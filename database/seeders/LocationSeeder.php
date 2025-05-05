<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $locations = [
            'Aritao, Nueva Vizcaya',
            'Bagabag, Nueva Vizcaya',
            'Bambang, Nueva Vizcaya',
            'Bayombong, Nueva Vizcaya',
            'Dahilayan, Nueva Vizcaya',
            'Dupax del Norte, Nueva Vizcaya',
            'Dupax del Sur, Nueva Vizcaya',
            'Kasibu, Nueva Vizcaya',
            'Kayapa, Nueva Vizcaya',
            'Santa Fe, Nueva Vizcaya',
            'Solano, Nueva Vizcaya',
            'Villaverde, Nueva Vizcaya',
        ];

        $data = array_map(function ($location) {
            return [
                'location' => $location,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $locations);

        // Insert data using Eloquent
        Location::insert($data);
    }
}
