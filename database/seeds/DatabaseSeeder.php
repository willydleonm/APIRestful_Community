<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::statement('SET FOREIGN_KEY_CHECHKS = 0');
       User::truncate();
       Profile::truncate();
       Semester::truncate();
       Course::truncate();
       Post::truncate();
       Comment::truncate();
       Favorite::truncate();
       Photo::truncate();

       $usersQt = 10;
       $coursesQt = 50;
       $profilesQt = 10;
       $postsQt = 20;
       $commentsQt = 15;
       $favoritesQt = 5;

       factory(User::class, usersQt)->create();
       factory(Profile::class, profilesQt)->create();
       factory(Course::class, coursesQt)->create();
       factory(Post::class, postsQt)->create();
       factory(Comment::class, commentsQt)->create();
       factory(Favorite::class, favoritesQt)->create();
    }
}
