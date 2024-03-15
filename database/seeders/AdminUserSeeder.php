<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = [
            ["admin", 'Админ', 'admin', 'AzSxDc132!'],
            // ["teacher", 'Методист2', 'metodist2@mail.ru', 'tasar232'], 
            // ["direct", 'Методист3', 'metodist3@mail.ru', 'tasar232'],
            // ["center", 'Методист4', 'metodist4@mail.ru', 'tasar232'],
            // ["rop", 'Методист5', 'metodist5@mail.ru', 'tasar232']
        ];
        foreach($role as $r){
            User::create([
                'type' => $r[0],
                'name' => $r[1],
                'last_name' => $r[1],
                'second_name' => $r[1],
                'email' => $r[2],
                'password' => bcrypt($r[3]),
                'mira_id' => 1
            ]);
        } 
    }
}
