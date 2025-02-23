<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                
                'national_card_number' => '123456789',
                'driving_lincense_number' => '987654321',
           
                'phone' => '1234567890',
                'path_peronal_card_image' => '/images/cards/john_doe.jpg',
                'path_driving_license_image_front' => '/images/drivers/john_doe_front.jpg',
                'path_driving_license_image_Back' => '/images/drivers/john_doe_back.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]);
    }
}