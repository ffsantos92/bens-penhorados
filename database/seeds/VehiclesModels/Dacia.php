<?php

namespace VehiclesModels;

use DB;
use Illuminate\Database\Seeder;

class Dacia extends Seeder
{
    public function run()
    {
        $makeId = DB::table('vehicles_makes')->where('name', 'Dacia')->pluck('id');

        $models = [
            ['name' => 'Duster', 'regex' => '/duster/i', 'make_id' => $makeId],
            ['name' => 'Lodgy', 'regex' => '/lodgy/i', 'make_id' => $makeId],
            ['name' => 'Logan', 'regex' => '/logan/i', 'make_id' => $makeId],
            ['name' => 'Sandero', 'regex' => '/sandero/i', 'make_id' => $makeId],
        ];

        DB::table('vehicles_models')->insert($models);
    }
}