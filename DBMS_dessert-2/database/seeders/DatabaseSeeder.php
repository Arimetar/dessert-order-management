<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\Dessert;
use App\Models\Employee;
use App\Models\Festival;
use App\Models\Festival_Dessert;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('1234567890'),
        ]);

        Festival::create([
            'Festival_name' => "ตรุษจีน 2568",
            'Start_date' => "2025-03-26",
            'End_date' => "2025-03-29"
        ]);

        Dessert::create([
            'Dessert_name' => 'ขนมเทียนไส้หวาน',
            'price' => 6,
            'image' => 'desserts/ouWVbPW9nwmx0DriuEqREJdxlTpugEQToh3CP99d.jpg'
        ]);
        Dessert::create([
            'Dessert_name' => 'ขนม',
            'price' => 6,
            'image' => 'desserts/8qAmh3mRCxiTdvKxxDAynvFGdjMfD87ayRfvjtDw.jpg'
        ]
        );

        Festival_Dessert::create([
            'FestivalID' => 1,
            'DessertID' => 1
        ]);
        Festival_Dessert::create([
            'FestivalID' => 1,
            'DessertID' => 2
        ]);

        Employee::create([
            'Employee_name' => 'jimmy',
            'user_id' => 1,
            'position' => 'หัวหน้าเชฟ',
        ]);


    }
}
