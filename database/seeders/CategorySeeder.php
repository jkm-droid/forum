<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\ForumList;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $faker = Faker::create('App\ForumList');
//        for ($i = 1; $i <= 6; $i++) {
//            $title = str_replace(".", " ", $faker->sentence(1));
//
//            DB::table('forum_lists')->insert([
//                'title' => ucfirst($title),
//                'description'=> $faker->sentence(3),
//                'slug' => str_replace(" ", "_", strtolower($title)),
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//        }

        $faker = Faker::create('App\Category');
        for ($i = 1; $i <= 97; $i++) {
            $title = str_replace(".", " ", $faker->sentence(2));
            $forum_list_id = ForumList::pluck('id')->random();

            DB::table('categories')->insert([
                'title' => ucfirst($title),
                'forum_list_id'=>$forum_list_id,
                'description'=> $faker->sentence(6),
                'slug' => str_replace(" ", "_", strtolower($title)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
//
//        $faker = Faker::create('App\User');
//        for ($i = 1; $i <= 500; $i++) {
//
//            DB::table('users')->insert([
//                'username' => $faker->userName,
//                'email' => $faker->email,
//                'password' => Hash::make("jkmq1234"),
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//        }
    }
}
