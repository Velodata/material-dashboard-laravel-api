<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@jsonapi.com',
            'password' => 'secret',
            'profile_image' => env('APP_URL').'/images/admin.jpg',
            'google_id' => ''

        ])->assignRole('admin');

        User::create([
            'name' => 'Creator',
            'email' => 'creator@jsonapi.com',
            'password' => 'secret',
            'profile_image' => env('APP_URL').'/images/creator.jpg',
            'google_id' => ''
        ])->assignRole('creator');

        User::create([
            'name' => 'Member',
            'email' => 'member@jsonapi.com',
            'password' => 'secret',
            'profile_image' => env('APP_URL').'/images/member.jpg',
            'google_id' => ''
        ])->assignRole('member');
    }
}
