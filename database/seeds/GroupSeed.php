<?php

use Carbon\Carbon;
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
        DB::table('users')->insert([
            'name' => 'Heather',
            'email' => 'heatherisafeather0605@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('temp'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('groups')->insert([
            'name' => 'Career Moms',
            'owner_id' => 1,
        ]);

        DB::table('group_users')->insert([
            'group_id' => 1,
            'user_id' => 1
        ]);

        DB::table('prompts')->insert([
            [
                'group_id' => 1,
                'prompt' => 'Quote of the Day'
            ],
            [
                'group_id' => 1,
                'prompt' => 'What are you excited about in the next 24 hours?'
            ],
            [
                'group_id' => 1,
                'prompt' => 'What do you want to focus on in the next 24 hours?'
            ],
            [
                'group_id' => 1,
                'prompt' => 'What did you read or listen to in the last 24 hours?'
            ],
            [
                'group_id' => 1,
                'prompt' => 'One thing that happened today: Lover'
            ],
            [
                'group_id' => 1,
                'prompt' => 'One thing that happened today: Self'
            ],
            [
                'group_id' => 1,
                'prompt' => 'One thing that happened today: Kid'
            ],
        ]);
    }
}
