<?php

use App\Post;
use App\User;
use App\Photo;
use App\Course;
use App\Comment;
use App\Profile;
use App\Favorite;
use App\Semester;
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
       DB::statement('SET FOREIGN_KEY_CHECKS = 0');
       
       Photo::truncate();
       Favorite::truncate();
       Comment::truncate();
       Post::truncate();
       Profile::truncate();
       User::truncate();
       Course::truncate();
       Semester::truncate();

       $semestersQt = 10;
       $coursesQt = 50;
       $usersQt = 10;
       $profilesQt = 10;
       $postsQt = 5;
       $commentsQt = 7;
       $favoritesQt = 2;
       $photosQt = 3;

       factory(Semester::class, $semestersQt)->create();
       factory(Course::class, $coursesQt)->create();
       factory(User::class, $usersQt)->create();
       factory(Profile::class, $profilesQt)->create();
       factory(Post::class, $postsQt)->create();
       factory(Comment::class, $commentsQt)->create();
       factory(Favorite::class, $favoritesQt)->create();
       factory(Photo::class, $photosQt)->create();
       DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
