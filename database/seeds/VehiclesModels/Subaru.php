<?php

namespace VehiclesModels;

use DB;
use Illuminate\Database\Seeder;

class Subaru extends Seeder
{
    public function run()
    {
        $makeId = DB::table('vehicles_makes')->where('name', 'Subaru')->pluck('id');

        $models = [
            ['name' => 'Forester', 'regex' => '/forester/i', 'make_id' => $makeId],
            ['name' => 'Impreza', 'regex' => '/impreza/i', 'make_id' => $makeId],
            ['name' => 'Legacy', 'regex' => '/legacy/i', 'make_id' => $makeId],
            ['name' => 'Outback', 'regex' => '/outback/i', 'make_id' => $makeId],
        ];

        DB::table('vehicles_models')->insert($models);
    }
}
