<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = Carbon::create("2015", "1", "1", "0", "0", "0");
        $end = Carbon::create("2022", "1", "10", "10", "55", "59");

        // timestampに変換する
        $min = strtotime($start);
        $max = strtotime($end);
        for ($i = 3; $i <= 50; $i++) {
          // ランダムなtimestampを取得し、フォーマット設定
            $datetime = rand($min, $max);
            $datetime = date('Y-m-d H:i:s', $datetime);

            $carbon = new Carbon($datetime);
            $created_at_display = $carbon->format('Y/m/d H:i');

            DB::table('admins')->insert([
                'uid' => Str::random(40),
                'name' => Str::random(10),
                'email' => Str::random(15).'@gmail.com',
                'email_verified_at' => $datetime,
                'password' => Str::random(40),
                'created_at' => $datetime,
                'updated_at' => $datetime,
                'role' => '3',
            ]);
        }

        /*
        / 本番環境用
        */

        // $carbon = Carbon::now();
        // $timestamp = $carbon->timestamp;

        // // ランダムなtimestampを取得し、フォーマット設定
        // $datetime = date('Y-m-d H:i:s', $timestamp);

        // DB::table('admins')->insert([
        //     'uid' => Str::random(40),
        //     'name' => "横田 陽平",
        //     'email' => 'yokota.02210301@gmail.com',
        //     'email_verified_at' => $datetime,
        //     'password' => Str::random(40),
        //     'created_at' => $datetime,
        //     'updated_at' => $datetime,
        //     'role' => '1',
        // ]);
    }
}
