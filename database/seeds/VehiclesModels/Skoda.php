<?php

namespace VehiclesModels;

use DB;
use Illuminate\Database\Seeder;

class Skoda extends Seeder
{
    public function run()
    {
        $makeId = DB::table('vehicles_makes')->where('name', 'Skoda')->pluck('id');

        $models = [
            ['name' => '105', 'regex' => '/105/', 'make_id' => $makeId],
            ['name' => 'Fabia', 'regex' => '/fabia/i', 'make_id' => $makeId],
            ['name' => 'Favorit', 'regex' => '/favorit/i', 'make_id' => $makeId],
            ['name' => 'Felicia', 'regex' => '/felicia/i', 'make_id' => $makeId],
            ['name' => 'Octavia', 'regex' => '/octavia/i', 'make_id' => $makeId],
            ['name' => 'Rapid', 'regex' => '/rapid/i', 'make_id' => $makeId],
            ['name' => 'Rapid Spaceback', 'regex' => '/rapid[\pP\s]?spaceback/i', 'make_id' => $makeId],
            ['name' => 'Roomster', 'regex' => '/roomster/i', 'make_id' => $makeId],
            ['name' => 'Superb', 'regex' => '/superb/i', 'make_id' => $makeId],
            ['name' => 'Yeti', 'regex' => '/yeti/i', 'make_id' => $makeId],
        ];

        DB::table('vehicles_models')->insert($models);
    }
}
