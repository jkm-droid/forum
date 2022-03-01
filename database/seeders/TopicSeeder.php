<?php

namespace Database\Seeders;

use App\HelperFunctions\MyHelperClass;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Message;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $helper = new MyHelperClass();
//        $faker = Faker::create('App\Topic');
//        for ($i = 1; $i <= 600; $i++) {
//            $title = str_replace(".", " ", $faker->sentence(8));
//            $author_name = User::pluck('username')->random();
//            $category_id = Category::pluck('id')->random();
//            $user_id = User::pluck('id')->random();
//
//            DB::table('topics')->insert([
//                'user_id'=> $user_id,
//                'category_id'=> $category_id,
//                'topic_id'=> $helper->generateUniqueId('forum','topics','topic_id'),
//                'title' => ucfirst($title),
//                'author' => $author_name,
//                'body' => $faker->sentence(50),
//                'slug' => str_replace(" ", "_", strtolower($title)),
//                'views'=>$faker->numberBetween(41,86),
//                'status'=>1,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//        }

//        $faker = Faker::create('App\Message');
//        for ($i = 1; $i <= 20000; $i++) {
//            $author_name = User::pluck('username')->random();
//            $topic_id = Topic::pluck('id')->random();
//            $user_id = User::pluck('id')->random();
//
//            DB::table('messages')->insert([
//                'user_id'=> $user_id,
//                'topic_id'=> $topic_id,
//                'message_id'=> $helper->generateUniqueId('forum','messages','message_id'),
//                'author' => $author_name,
//                'body' => $faker->sentence(100),
//                'likes'=>$faker->numberBetween(30,90),
//                'status'=>1,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//        }

        $faker = Faker::create('App\Comment');
        for ($i = 1; $i <= 10000; $i++) {
            $author_name = User::pluck('username')->random();
            $message_id = Message::pluck('id')->random();

            DB::table('comments')->insert([
                'message_id'=> $message_id,
                'author' => $author_name,
                'comment_id' => $helper->generateUniqueId('forum','comments','comment_id'),
                'body' => $faker->sentence(90),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

    }
}
