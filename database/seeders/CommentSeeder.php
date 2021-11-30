<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Message');
        for ($i = 1; $i <= 200; $i++) {
            $author_name = User::pluck('username')->random();
            $message_id = Message::pluck('id')->random();

            DB::table('comments')->insert([
                'message_id'=> $message_id,
                'author' => $author_name,
                'body' => $faker->sentence(90),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
