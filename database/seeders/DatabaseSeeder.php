<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);
        User::factory(10)->create();

        $channels = collect(['general', 'laravel', 'reverb', 'echo', 'livewire']);

        $channels->each(function ($channel) {
            Channel::firstOrCreate(['name' => $channel])
                ->subscribers()
                ->attach(
                    User::inRandomOrder()
                        ->take(rand(1, 10))->get()
                );
        });

    }
}
