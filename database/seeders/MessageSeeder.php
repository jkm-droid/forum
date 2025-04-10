<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Message');
        for ($i = 1; $i <= 20000; $i++) {
            $author_name = User::pluck('username')->random();
            $topic_id = Topic::pluck('id')->random();
            $user_id = User::pluck('id')->random();

            DB::table('messages')->insert([
                'user_id'=> $user_id,
                'topic_id'=> $topic_id,
                'author' => $author_name,
                'body' => $faker->sentence(100),
                'likes'=>$faker->numberBetween(30,90),
                'status'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
