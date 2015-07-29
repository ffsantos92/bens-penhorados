<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VehicleModels;

use DB;
use Illuminate\Database\Seeder;

class BMW extends Seeder
{
    public function run()
    {
        $makeId = DB::table('vehicle_makes')->where('name', 'BMW')->pluck('id');

        $models = [
            ['name' => '114', 'regex' => '/114/', 'make_id' => $makeId],
            ['name' => '116', 'regex' => '/116/', 'make_id' => $makeId],
            ['name' => '118', 'regex' => '/118/', 'make_id' => $makeId],
            ['name' => '120', 'regex' => '/120/', 'make_id' => $makeId],
            ['name' => '123', 'regex' => '/123/', 'make_id' => $makeId],
            ['name' => '125', 'regex' => '/125/', 'make_id' => $makeId],
            ['name' => '118 Cabriolet', 'regex' => '/118[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '120 Cabriolet', 'regex' => '/120[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '123 Cabriolet', 'regex' => '/123[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '118 Coupé', 'regex' => '/118[\pP\s]?coupe/i', 'make_id' => $makeId],
            ['name' => '120 Coupé', 'regex' => '/120[\pP\s]?coupe/i', 'make_id' => $makeId],
            ['name' => '123 Coupé', 'regex' => '/123[\pP\s]?coupe/i', 'make_id' => $makeId],
            ['name' => '216', 'regex' => '/216/', 'make_id' => $makeId],
            ['name' => '218', 'regex' => '/218/', 'make_id' => $makeId],
            ['name' => '220', 'regex' => '/220/', 'make_id' => $makeId],
            ['name' => '315', 'regex' => '/315/', 'make_id' => $makeId],
            ['name' => '316', 'regex' => '/316/', 'make_id' => $makeId],
            ['name' => '318', 'regex' => '/318/', 'make_id' => $makeId],
            ['name' => '320', 'regex' => '/320/', 'make_id' => $makeId],
            ['name' => '323', 'regex' => '/323/', 'make_id' => $makeId],
            ['name' => '324', 'regex' => '/324/', 'make_id' => $makeId],
            ['name' => '325', 'regex' => '/325/', 'make_id' => $makeId],
            ['name' => '328', 'regex' => '/328/', 'make_id' => $makeId],
            ['name' => '330', 'regex' => '/330/', 'make_id' => $makeId],
            ['name' => '335', 'regex' => '/335/', 'make_id' => $makeId],
            ['name' => 'ActiveHybrid 3', 'regex' => '/activehybrid[\pP\s]?3/i', 'make_id' => $makeId],
            ['name' => 'M3', 'regex' => '/m3/i', 'make_id' => $makeId],
            ['name' => '316 Compact', 'regex' => '/316[\pP\s]?compact/i', 'make_id' => $makeId],
            ['name' => '318 Compact', 'regex' => '/318[\pP\s]?compact/i', 'make_id' => $makeId],
            ['name' => '318 Cabriolet', 'regex' => '/318[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '320 Cabriolet', 'regex' => '/320[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '323 Cabriolet', 'regex' => '/323[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '325 Cabriolet', 'regex' => '/325[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '328 Cabriolet', 'regex' => '/328[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '330 Cabriolet', 'regex' => '/330[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '335 Cabriolet', 'regex' => '/335[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => 'M3 Cabriolet', 'regex' => '/m3[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '318 Gran Turismo', 'regex' => '/318[\pP\s]?gran[\pP\s]?turismo/i', 'make_id' => $makeId],
            ['name' => '320 Gran Turismo', 'regex' => '/320[\pP\s]?gran[\pP\s]?turismo/i', 'make_id' => $makeId],
            ['name' => '418', 'regex' => '/418/', 'make_id' => $makeId],
            ['name' => '420', 'regex' => '/420/', 'make_id' => $makeId],
            ['name' => '425', 'regex' => '/425/', 'make_id' => $makeId],
            ['name' => '435', 'regex' => '/435/', 'make_id' => $makeId],
            ['name' => 'M4', 'regex' => '/m4/i', 'make_id' => $makeId],
            ['name' => '518', 'regex' => '/518/', 'make_id' => $makeId],
            ['name' => '520', 'regex' => '/520/', 'make_id' => $makeId],
            ['name' => '523', 'regex' => '/523/', 'make_id' => $makeId],
            ['name' => '524', 'regex' => '/524/', 'make_id' => $makeId],
            ['name' => '525', 'regex' => '/525/', 'make_id' => $makeId],
            ['name' => '528', 'regex' => '/528/', 'make_id' => $makeId],
            ['name' => '530', 'regex' => '/530/', 'make_id' => $makeId],
            ['name' => '535', 'regex' => '/535/', 'make_id' => $makeId],
            ['name' => '545', 'regex' => '/545/', 'make_id' => $makeId],
            ['name' => 'M5', 'regex' => '/m5/i', 'make_id' => $makeId],
            ['name' => 'M550', 'regex' => '/m550/i', 'make_id' => $makeId],
            ['name' => '520 Gran Turismo', 'regex' => '/520[\pP\s]?gran[\pP\s]?turismo/i', 'make_id' => $makeId],
            ['name' => '530 Gran Turismo', 'regex' => '/530[\pP\s]?gran[\pP\s]?turismo/i', 'make_id' => $makeId],
            ['name' => '535 Gran Turismo', 'regex' => '/535[\pP\s]?gran[\pP\s]?turismo/i', 'make_id' => $makeId],
            ['name' => '630', 'regex' => '/630/', 'make_id' => $makeId],
            ['name' => '633', 'regex' => '/633/', 'make_id' => $makeId],
            ['name' => '635', 'regex' => '/635/', 'make_id' => $makeId],
            ['name' => '640', 'regex' => '/640/', 'make_id' => $makeId],
            ['name' => '645', 'regex' => '/645/', 'make_id' => $makeId],
            ['name' => '650', 'regex' => '/650/', 'make_id' => $makeId],
            ['name' => 'M6', 'regex' => '/m6/i', 'make_id' => $makeId],
            ['name' => '630 Cabriolet', 'regex' => '/630[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '635 Cabriolet', 'regex' => '/635[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '640 Cabriolet', 'regex' => '/640[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '645 Cabriolet', 'regex' => '/645[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => 'M6 Cabriolet', 'regex' => '/m6[\pP\s]?cabriolet/i', 'make_id' => $makeId],
            ['name' => '725', 'regex' => '/725/', 'make_id' => $makeId],
            ['name' => '728', 'regex' => '/728/', 'make_id' => $makeId],
            ['name' => '730', 'regex' => '/730/', 'make_id' => $makeId],
            ['name' => '730L', 'regex' => '/730l/i', 'make_id' => $makeId],
            ['name' => '735', 'regex' => '/735/', 'make_id' => $makeId],
            ['name' => '735L', 'regex' => '/735l/i', 'make_id' => $makeId],
            ['name' => '740', 'regex' => '/740/', 'make_id' => $makeId],
            ['name' => '740L', 'regex' => '/740l/i', 'make_id' => $makeId],
            ['name' => '745', 'regex' => '/745/', 'make_id' => $makeId],
            ['name' => '750', 'regex' => '/750/', 'make_id' => $makeId],
            ['name' => '760L', 'regex' => '/760l/i', 'make_id' => $makeId],
            ['name' => 'ActiveHybrid 7', 'regex' => '/activehybrid[\pP\s]?7/i', 'make_id' => $makeId],
            ['name' => '850', 'regex' => '/850/', 'make_id' => $makeId],
            ['name' => 'M1', 'regex' => '/m1/i', 'make_id' => $makeId],
            ['name' => 'Z3 M', 'regex' => '/z3[\pP\s]?m/i', 'make_id' => $makeId],
            ['name' => 'Z4 M', 'regex' => '/z4[\pP\s]?m/i', 'make_id' => $makeId],
            ['name' => 'X1', 'regex' => '/x1/i', 'make_id' => $makeId],
            ['name' => 'X3', 'regex' => '/x3/i', 'make_id' => $makeId],
            ['name' => 'X4', 'regex' => '/x4/i', 'make_id' => $makeId],
            ['name' => 'X5', 'regex' => '/x5/i', 'make_id' => $makeId],
            ['name' => 'X6', 'regex' => '/x6/i', 'make_id' => $makeId],
            ['name' => 'Z3', 'regex' => '/z3/i', 'make_id' => $makeId],
            ['name' => 'Z4', 'regex' => '/z4/i', 'make_id' => $makeId],
            ['name' => '1600', 'regex' => '/1600/', 'make_id' => $makeId],
            ['name' => '1602', 'regex' => '/1602/', 'make_id' => $makeId],
            ['name' => '501', 'regex' => '/501/', 'make_id' => $makeId],
            ['name' => '502', 'regex' => '/502/', 'make_id' => $makeId],
            ['name' => 'i3', 'regex' => '/i3/i', 'make_id' => $makeId],
            ['name' => 'i8', 'regex' => '/i8/i', 'make_id' => $makeId],
        ];

        DB::table('vehicle_models')->insert($models);
    }
}
