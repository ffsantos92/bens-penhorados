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
use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller;

/**
 * This is the home controller class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * Show both latest and items ending soon.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $data = [];
        $data['latest'] = self::getLatestItems(8);
        $data['endingSoon'] = self::getItemsEndingSoon(8);

        return view('home', $data);
    }

    /**
     * Get the latest items.
     *
     * @param int $howMany
     *
     * @return array
     */
    public static function getLatestItems($howMany)
    {
        $results = Item::latest($howMany)->get();

        $items = [];
        foreach ($results as $result) {
            $item = [
                'title'          => $result->title,
                'itemSlug'       => $result->slug,
                'categorySlug'   => $result->category()->pluck('slug'),
                'price'          => $result->price,
                'image'          => json_decode($result->images)[0],
            ];

            $items[] = $item;
        }

        return $items;
    }

    /**
     * Get the items ending soon.
     *
     * @param int $howMany
     *
     * @return array
     */
    public static function getItemsEndingSoon($howMany)
    {
        $results = Item::endingSoon($howMany)->get();

        $items = [];
        foreach ($results as $result) {
            $item = [
                'title'         => $result->title,
                'itemSlug'      => $result->slug,
                'categorySlug'  => $result->category()->pluck('slug'),
                'price'         => $result->price,
                'image'         => json_decode($result->images)[0],
                'timeleft'      => $result->acceptance_dt->diffForHumans(Carbon::now(), true),
            ];

            $items[] = $item;
        }

        return $items;
    }
}
