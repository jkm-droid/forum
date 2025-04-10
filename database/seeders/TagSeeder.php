<?php

namespace Database\Seeders;

use App\Helpers\HelperService;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $helper = new HelperService();

        $faker = Faker::create('App\Tag');
        for ($i = 1; $i <= 10000; $i++) {
            $title = str_replace('.', "",$faker->word);
            $slug = strtolower($title);
            DB::table('tags')->insert([
                'title' =>  $title,
                'tag_id'=> $helper->generateUniqueId('forum','tags','tag_id'),
                'slug' => $slug,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
