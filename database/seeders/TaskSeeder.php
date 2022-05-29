<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $task1 = [
            ['id' => '1','user_id' => '1','name' => 'Boot_Docker','description' => 'Boot Docker script','created_at' => '2022-04-18 12:19:26','updated_at' => '2022-04-19 12:19:26']
        ];
        $task2 = [
            ['id' => '2','user_id' => '1','name' => 'Boot_Routine_Function','description' => 'Boot Routine Functions like DB Migration ..','created_at' => '2022-04-18 12:25:26','updated_at' => '2022-04-19 12:30:26']
        ];
        $task3 = [
            ['id' => '3','user_id' => '2','name' => 'Boot_All','description' => 'Boot All services','created_at' => '2022-04-18 12:30:26','updated_at' => '2022-04-19 12:35:26']
        ];
        DB::table('tasks')->insert($task1);
        DB::table('tasks')->insert($task2);
        DB::table('tasks')->insert($task3);
    }
}
