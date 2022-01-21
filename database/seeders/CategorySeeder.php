<?php

namespace Database\Seeders;

use App\HelperFunctions\MakeAvatars;
use App\HelperFunctions\MyHelperClass;
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
//                'status'=>1,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//        }

        $faker = Faker::create('App\Category');
        for ($i = 1; $i <= 40; $i++) {
            $title = str_replace(".", " ", $faker->sentence(2));
            $forum_list_id = ForumList::pluck('id')->random();

            DB::table('categories')->insert([
                'title' => ucfirst($title),
                'forum_list_id'=>$forum_list_id,
                'description'=> $faker->sentence(6),
                'slug' => str_replace(" ", "_", strtolower($title)),
                'status'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
//
//        $faker = Faker::create('App\User');
//        $helper = new MyHelperClass();
//        $avatar = new MakeAvatars();
//        for ($i = 1; $i <= 2000; $i++) {
//            $username = $faker->userName;
//
//            DB::table('users')->insert([
//                'user_id'=> $helper->generateUniqueId($username,'users','user_id'),
//                'username' => $username,
//                'email' => $faker->email,
//                'score'=>$faker->numberBetween(247, 15561),
//                'rating'=>$faker->numberBetween(10, 89),
//                'password' => Hash::make("jkmq1234"),
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ]);
//        }
    }
}
