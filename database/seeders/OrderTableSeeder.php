<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // 2つの日付の間のランダム日を生成する
    $start = Carbon::create("2015", "1", "1", "0", "0", "0");
    $end = Carbon::create("2022", "1", "3", "10", "55", "59");

    // timestampに変換する
    $min = strtotime($start);
    $max = strtotime($end);

    for ($i = 1; $i <= 50; $i++) {
      // ランダムなtimestampを取得し、フォーマット設定
      $datetime = rand($min, $max);
      $datetime = date('Y-m-d H:i:s', $datetime);

      DB::table('orders')->insert([
        'user_id' => '1',
        'company' => Str::random(10).".inc",
        'client' => "シード".$i,
        'email' => Str::random(10).'@gmail.com',
        'question' => Str::random(10),
        'status' => rand(1, 5),
        'created_at' => $datetime,
        'updated_at' => $datetime,
      ]);
    }
  }
}
