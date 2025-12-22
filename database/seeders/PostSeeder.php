<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        $types = ['LOST', 'FOUND'];
        
        foreach (range(1, 15) as $index) {
            $type = $faker->randomElement($types);
            $titlePrefix = $type === 'LOST' ? 'Perdu : ' : 'Trouvé : ';
            
            DB::table('posts')->insert([
                'title' => $titlePrefix . $faker->words(3, true),
                'content' => $faker->paragraph(2),
                'type' => $type,
                'location' => $faker->city . ', ' . $faker->streetName,
                'contact_info' => $faker->phoneNumber . ' - ' . $faker->email,
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
