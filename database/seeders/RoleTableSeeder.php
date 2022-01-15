<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carbon = Carbon::now();
        $timestamp = $carbon->timestamp;
        $datetime = date('Y-m-d H:i:s', $timestamp);

        DB::table('roles')->insert([
            'label' => 'root',
            'name' => 'ルート',
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ]);

        DB::table('roles')->insert([
            'label' => 'leader',
            'name' => 'リーダー',
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ]);

        DB::table('roles')->insert([
            'label' => 'user',
            'name' => 'ユーザー',
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ]);
    }
}
