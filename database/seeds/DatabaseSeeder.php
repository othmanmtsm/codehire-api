<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("insert into roles values(1,'freelancer')");
        DB::insert("insert into roles values(2,'client')");
        $user = factory(App\User::class)->create();
        DB::insert('insert into role_user values (?,?)',[$user->id,1]);
    }
}
