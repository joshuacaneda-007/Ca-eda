<?php

namespace Database\Seeders;

use App\Models\AnimeList;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@animetracker.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'gender'   => 'Male',
            'address'  => '123 Anime Street, Tokyo',
        ]);

        $user1 = User::create([
            'name'     => 'Sakura Tanaka',
            'email'    => 'sakura@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'gender'   => 'Female',
            'address'  => '456 Manga Ave, Osaka',
        ]);

        $user2 = User::create([
            'name'     => 'Kenji Yamamoto',
            'email'    => 'kenji@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'gender'   => 'Male',
        ]);

        $animeData = [
            ['title' => 'Attack on Titan', 'genre' => 'Action', 'episodes' => 87, 'episodes_watched' => 87, 'status' => 'Completed', 'rating' => 10],
            ['title' => 'Demon Slayer', 'genre' => 'Action', 'episodes' => 44, 'episodes_watched' => 44, 'status' => 'Completed', 'rating' => 9],
            ['title' => 'Jujutsu Kaisen', 'genre' => 'Action', 'episodes' => 48, 'episodes_watched' => 30, 'status' => 'Watching', 'rating' => 9],
            ['title' => 'One Piece', 'genre' => 'Adventure', 'episodes' => 1100, 'episodes_watched' => 500, 'status' => 'Watching', 'rating' => 8],
            ['title' => 'Naruto Shippuden', 'genre' => 'Action', 'episodes' => 500, 'episodes_watched' => 500, 'status' => 'Completed', 'rating' => 8],
            ['title' => 'Your Name', 'genre' => 'Romance', 'episodes' => 1, 'episodes_watched' => 1, 'status' => 'Completed', 'rating' => 10],
            ['title' => 'Sword Art Online', 'genre' => 'Fantasy', 'episodes' => 25, 'episodes_watched' => 10, 'status' => 'On Hold', 'rating' => 7],
            ['title' => 'Fullmetal Alchemist: Brotherhood', 'genre' => 'Adventure', 'episodes' => 64, 'episodes_watched' => 0, 'status' => 'Plan to Watch', 'rating' => null],
            ['title' => 'Death Note', 'genre' => 'Thriller', 'episodes' => 37, 'episodes_watched' => 37, 'status' => 'Completed', 'rating' => 9],
            ['title' => 'Hunter x Hunter', 'genre' => 'Adventure', 'episodes' => 148, 'episodes_watched' => 50, 'status' => 'Watching', 'rating' => 9],
        ];

        foreach ($animeData as $data) {
            AnimeList::create(array_merge($data, ['user_id' => $admin->id]));
        }

        AnimeList::create(['user_id' => $user1->id, 'title' => 'Sailor Moon', 'genre' => 'Romance', 'episodes' => 200, 'episodes_watched' => 200, 'status' => 'Completed', 'rating' => 8]);
        AnimeList::create(['user_id' => $user1->id, 'title' => 'Cardcaptor Sakura', 'genre' => 'Romance', 'episodes' => 70, 'episodes_watched' => 70, 'status' => 'Completed', 'rating' => 9]);
        AnimeList::create(['user_id' => $user2->id, 'title' => 'Dragon Ball Z', 'genre' => 'Action', 'episodes' => 291, 'episodes_watched' => 150, 'status' => 'Watching', 'rating' => 8]);
    }
}
