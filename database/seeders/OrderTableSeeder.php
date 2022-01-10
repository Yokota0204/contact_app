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
    $end = Carbon::create("2022", "1", "10", "10", "55", "59");

    // timestampに変換する
    $min = strtotime($start);
    $max = strtotime($end);

    // for ($i = 1; $i <= 50; $i++) {
    //   // ランダムなtimestampを取得し、フォーマット設定
    //   $datetime = rand($min, $max);
    //   $datetime = date('Y-m-d H:i:s', $datetime);

    //   $carbon = new Carbon($datetime);
		// 	$created_at_display = $carbon->format('Y/m/d H:i');

    //   DB::table('orders')->insert([
    //     'user_id' => '1',
    //     'company' => Str::random(10).".inc",
    //     'client' => "シード".$i,
    //     'email' => Str::random(10).'@gmail.com',
    //     'question' => Str::random(10),
    //     'status' => rand(1, 5),
    //     'created_at' => $datetime,
    //     'updated_at' => $datetime,
    //     'created_at_display' => $created_at_display,
    //   ]);
    // }

    // ランダムなtimestampを取得し、フォーマット設定
    $datetime = rand($min, $max);
    $datetime = date('Y-m-d H:i:s', $datetime);

    $carbon = new Carbon($datetime);
    $created_at_display = $carbon->format('Y/m/d H:i');

    DB::table('orders')->insert([
      'user_id' => '1',
      'company' => "株式会社雑談兄弟",
      'client' => "横田 陽平",
      'email' => 'yokota.02210301@gmail.com',
      'question' => 'テスト用のボディ.\nテストです。',
      'status' => 1,
      'created_at' => $datetime,
      'updated_at' => $datetime,
      'created_at_display' => $created_at_display,
    ]);
  }
}
