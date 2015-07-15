<?php

namespace App\Models\Items;

use DB;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'code';

    public static function paginated($limit)
    {
        $results = Item::join('vehicles', 'vehicles.code', '=', 'items.code')
        ->select('items.price', 'items.images')
        ->paginate($limit);

        if ($results->isEmpty()) {
            return;
        }

        $data = [];
        $data['from'] = $results->firstItem();
        $data['to'] = $results->lastItem();
        $data['total'] = $results->total();
        $data['limit'] = $results->perPage();

        foreach ($results as $result) {
            $item = new self();
            $item->price = $result->price;
            $item->image = json_decode($result->images)[0];
            $data['items'][] = $item;
        }

        return $data;
    }

    public static function allColors()
    {
        return DB::table('vehicles_colors')->get();
    }

    public static function allMakes()
    {
        return DB::table('vehicles_makes_models')->where('parent_id', null)->get();
    }

    public static function allMakesAndModels()
    {
        return DB::table('vehicles_makes_models')->get();
    }
}
