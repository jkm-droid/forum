<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
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
        $faker = Faker::create('App\Topic');
        for ($i = 1; $i <= 1000; $i++) {
            $title = str_replace(".", " ", $faker->sentence(8));
            $author_name = User::pluck('username')->random();
            $category_id = Category::pluck('id')->random();

            DB::table('topics')->insert([
                'category_id'=> $category_id,
                'title' => ucfirst($title),
                'author' => $author_name,
                'body' => $faker->sentence(300),
                'slug' => str_replace(" ", "_", strtolower($title)),
                'views'=>$faker->numberBetween(41,86),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
