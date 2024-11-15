<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' =>  Hash::make('admin'),
        ]);

         User::factory(5)->create();
         Post::factory(50)->create();

    }
}
