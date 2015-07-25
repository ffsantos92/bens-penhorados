<?php

namespace VehiclesModels;

use DB;
use Illuminate\Database\Seeder;

class Suzuki extends Seeder
{
    public function run()
    {
        $makeId = DB::table('vehicles_makes')->where('name', 'Suzuki')->pluck('id');

        $models = [
            ['name' => 'Alto', 'regex' => '/alto/i', 'make_id' => $makeId],
            ['name' => 'Baleno', 'regex' => '/baleno/i', 'make_id' => $makeId],
            ['name' => 'Grand Vitara', 'regex' => '/grand[\pP\s]?vitara/i', 'make_id' => $makeId],
            ['name' => 'Ignis', 'regex' => '/ignis/i', 'make_id' => $makeId],
            ['name' => 'Jimny', 'regex' => '/jimny/i', 'make_id' => $makeId],
            ['name' => 'Liana', 'regex' => '/liana/i', 'make_id' => $makeId],
            ['name' => 'Samurai', 'regex' => '/samurai/i', 'make_id' => $makeId],
            ['name' => 'S-Cross', 'regex' => '/s[\pP\s]?cross/i', 'make_id' => $makeId],
            ['name' => 'Splash', 'regex' => '/splash/i', 'make_id' => $makeId],
            ['name' => 'Swift', 'regex' => '/swift/i', 'make_id' => $makeId],
            ['name' => 'SX4', 'regex' => '/sx4/i', 'make_id' => $makeId],
            ['name' => 'Vitara', 'regex' => '/vitara/i', 'make_id' => $makeId],
            ['name' => 'Wagon R', 'regex' => '/wagon[\pP\s]?r/i', 'make_id' => $makeId],
            ['name' => 'Wagon R+', 'regex' => '/wagon[\pP\s]?r+/i', 'make_id' => $makeId],
        ];

        DB::table('vehicles_models')->insert($models);
    }
}
