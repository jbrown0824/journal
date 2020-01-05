<?php

use Illuminate\Database\Seeder;

class GroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => 'Career Moms',
        ]);
    }
}
