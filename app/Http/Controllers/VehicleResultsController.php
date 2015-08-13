<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use App\Models\Items\Item;
use App\Models\Items\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * This is the vehicle results controller class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class VehicleResultsController extends Controller
{
    /**
     * Show a list of vehicles.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $genericFilters = [
            'per_page'           => (int) $request->input('limit') ?: 5,
            'district_id'        => $request->input('district'),
            'municipality_id'    => $request->input('municipality'),
            'purchase_type_id'   => $request->input('purchasetype'),
            'with_images'        => $request->input('withimages'),
            'ignore_suspended'   => $request->input('nosuspended'),
        ];

        $vehicleFilters = [
            'make_id'           => $request->input('make'),
            'model_id'          => $request->input('model'),
            'category_id'       => $request->input('category'),
            'type_id'           => $request->input('type'),
            'color_id'          => $request->input('color'),
            'fuel_id'           => $request->input('fuel'),
            'start_year'        => $request->input('start'),
            'end_year'          => $request->input('end'),
            'is_good_condition' => is_null($request->input('goodcondition')) ? null : (bool) $request->input('goodcondition'),
        ];

        $vehicles = $this->getVehicles($genericFilters, $vehicleFilters);
        $data = $this->paginateVehicles($vehicles);

        return response()->json($data, 200);
    }

    /**
     * Paginate vehicles.
     *
     * @param LengthAwarePaginator $vehicles
     *
     * @return array
     */
    public function paginateVehicles(LengthAwarePaginator $vehicles)
    {
        $noResults = $vehicles->isEmpty() ? true : false;

        $data = [];
        $data['from'] = $noResults ? 0 : $vehicles->firstItem();
        $data['to'] = $noResults ? 0 : $vehicles->lastItem();
        $data['total'] = $noResults ? 0 : $vehicles->total();
        $data['limit'] = $noResults ? 0 : $vehicles->perPage();

        $data['items'] = [];
        foreach ($vehicles as $vehicle) {
            $item = [
                    'title' => $vehicle->item->title,
                    'slug'  => $vehicle->item->slug,
                    'price' => $vehicle->item->price,
                    'image' => json_decode($vehicle->item->images) ? json_decode($vehicle->item->images)[0] : null,
                    'year'  => $vehicle->year,
                    'fuel'  => $vehicle->fuel()->pluck('name'),
                ];

            $data['items'][] = $item;
        }

        return $data;
    }

    /**
     * Get active vehicles.
     *
     * @param array $genericFilters
     * @param array $vehicleFilters
     *
     * @return LengthAwarePaginator
     */
    public function getVehicles($genericFilters, $vehicleFilters)
    {
        $ids = $this->getIdsByGenericFilters($genericFilters);
        $query = $this->getQueryByVehicleFilters($ids, $vehicleFilters);

        return $query->paginate($genericFilters['per_page']);
    }

    /**
     * Get ids by applying generic filters.
     *
     * @param array $filters
     *
     * @return array
     */
    private function getIdsByGenericFilters($filters)
    {
        $query = Item::active()->ofType(Vehicle::class);

        if (isset($filters['district_id'])) {
            $query->ofDistrict($filters['district_id']);
        }
        if (isset($filters['municipality_id'])) {
            $query->ofMunicipality($filters['municipality_id']);
        }
        if (isset($filters['purchase_type_id'])) {
            $query->ofPurchaseType($filters['purchase_type_id']);
        }
        if (isset($filters['with_images'])) {
            $query->onlyWithImages();
        }
        if (isset($filters['ignore_suspended'])) {
            $query->ignoreSuspended();
        }

        return $query->lists('itemable_id');
    }

    /**
     * Get a query by applying vehicle filters.
     *
     * @param array $ids
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getQueryByVehicleFilters($ids, $filters)
    {
        $query = Vehicle::whereIn('id', $ids);

        if (isset($filters['make_id'])) {
            $query->ofMake($filters['make_id']);
        }
        if (isset($filters['model_id'])) {
            $query->ofModel($filters['model_id']);
        }
        if (isset($filters['category_id'])) {
            $query->ofCategory($filters['category_id']);
        }
        if (isset($filters['type_id'])) {
            $query->ofType($filters['type_id']);
        }
        if (isset($filters['color_id'])) {
            $query->ofColor($filters['color_id']);
        }
        if (isset($filters['fuel_id'])) {
            $query->ofFuel($filters['fuel_id']);
        }
        if (isset($filters['start_year']) || isset($filters['end_year'])) {
            $query->betweenYears($filters['start_year'], $filters['end_year']);
        }
        if (isset($filters['is_good_condition'])) {
            $query->isGoodCondition($filters['is_good_condition']);
        }

        return $query;
    }
}
