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
        DB::insert("insert into skills values(1,'php')");
        DB::insert("insert into skills values(2,'javascript')");
        DB::insert("insert into skills values(3,'nodejs')");
        DB::insert("insert into skills values(4,'mongo')");
        DB::insert("insert into categories values(1,'Programmation')");
        DB::insert("insert into categories values(2,'UI/UX Design')");
        DB::insert("insert into categories values(3,'Mobile dev')");
        DB::insert("insert into statuses values(1,'Available')");
    }
}
