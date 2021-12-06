<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Topic;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\TopicTag');
        for ($i = 1; $i <= 2000; $i++) {
            DB::table('topic_tags')->insert([
                'topic_id' =>  Topic::pluck('id')->random(),
                'tag_id' => Tag::pluck('id')->random(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
