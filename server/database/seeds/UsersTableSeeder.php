<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    User::forceCreate([
        'name' => env('USER_NAME'),
        'email' => env('USER_EMAIL'),
        'password' => Hash::make(env('USER_PASSWORD')),
        'api_token' => env('API_TOKEN'),
    ]);
  }
}