<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Models\Items;

use App\Models\Attributes\Vehicle\VehicleCategory;
use App\Models\Attributes\Vehicle\VehicleColor;
use App\Models\Attributes\Vehicle\VehicleFuel;
use App\Models\Attributes\Vehicle\VehicleMake;
use App\Models\Attributes\Vehicle\VehicleModel;
use App\Models\Attributes\Vehicle\VehicleType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the vehicle model class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 *
 * @property int                  $id
 * @property int|null             $year
 * @property bool|null            $is_good_condition
 * @property Item                 $item
 * @property VehicleMake|null     $make
 * @property VehicleModel|null    $model
 * @property VehicleColor|null    $color
 * @property VehicleFuel|null     $fuel
 * @property VehicleCategory|null $category
 * @property VehicleType|null     $type
 */
class Vehicle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicles';

    /**
     * The primary key column.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicate if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the vehicle's generic data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }

    /**
     * A vehicle can have one make.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function make()
    {
        return $this->hasOne(VehicleMake::class, 'id', 'make_id');
    }

    /**
     * A vehicle can have one model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function model()
    {
        return $this->hasOne(VehicleModel::class, 'id', 'model_id');
    }

    /**
     * A vehicle can have one color.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function color()
    {
        return $this->hasOne(VehicleColor::class, 'id', 'color_id');
    }

    /**
     * A vehicle can have one fuel type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fuel()
    {
        return $this->hasOne(VehicleFuel::class, 'id', 'fuel_id');
    }

    /**
     * A vehicle can have one category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(VehicleCategory::class, 'id', 'category_id');
    }

    /**
     * A vehicle can have one type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(VehicleType::class, 'id', 'type_id');
    }

    /**
     * Scope a query to only include active vehicles.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        $ids = Item::where('itemable_type', self::class)
                ->where('acceptance_dt', '>', Carbon::now())
                ->lists('itemable_id')->all();

        return $query->whereIn('id', $ids);
    }

    /**
     * Scope a query to only include vehicles of a given make.
     *
     * @param Builder $query
     * @param int     $makeId
     *
     * @return Builder
     */
    public function scopeOfMake(Builder $query, $makeId)
    {
        if (isset($makeId)) {
            return $query->where('make_id', $makeId);
        }
    }

    /**
     * Scope a query to only include vehicles of a given model.
     *
     * @param Builder $query
     * @param int     $modelId
     *
     * @return Builder
     */
    public function scopeOfModel(Builder $query, $modelId)
    {
        if (isset($modelId)) {
            return $query->where('model_id', $modelId);
        }
    }

    /**
     * Scope a query to only include vehicles of a given color.
     *
     * @param Builder $query
     * @param int     $colorId
     *
     * @return Builder
     */
    public function scopeOfColor(Builder $query, $colorId)
    {
        if (isset($colorId)) {
            return $query->where('color_id', $colorId);
        }
    }

    /**
     * Scope a query to only include vehicles of a given fuel type.
     *
     * @param Builder $query
     * @param int     $fuelId
     *
     * @return Builder
     */
    public function scopeOfFuel(Builder $query, $fuelId)
    {
        if (isset($fuelId)) {
            return $query->where('fuel_id', $fuelId);
        }
    }

    /**
     * Scope a query to only include vehicles of a given category.
     *
     * @param Builder $query
     * @param int     $categoryId
     *
     * @return Builder
     */
    public function scopeOfCategory(Builder $query, $categoryId)
    {
        if (isset($categoryId)) {
            return $query->where('category_id', $categoryId);
        }
    }

    /**
     * Scope a query to only include vehicles of a given type.
     *
     * @param Builder $query
     * @param int     $typeId
     *
     * @return Builder
     */
    public function scopeOfType(Builder $query, $typeId)
    {
        if (isset($typeId)) {
            return $query->where('type_id', $typeId);
        }
    }

    /**
     * Scope a query to only include vehiles of a given year range.
     *
     * @param Builder  $query
     * @param int|null $minYear
     * @param int|null $maxYear
     *
     * @return Builder
     */
    public function scopeBetweenYears(Builder $query, $minYear, $maxYear)
    {
        // Get vehicles between a year range
        if (isset($minYear) && isset($maxYear)) {
            return $query->where('year', '>=', $minYear)->where('year', '<=', $maxYear);
        }

        // Get vehicles older than
        if (isset($minYear)) {
            return $query->where('year', '>=', $minYear);
        }

        // Get vehicles younger than
        if (isset($maxYear)) {
            return $query->where('year', '<=', $maxYear);
        }
    }

    /**
     * Scope a query to only include vehicles in good or bad condition.
     *
     * @param Builder $query
     * @param bool    $isGoodCondition
     *
     * @return Builder
     */
    public function scopeIsGoodCondition(Builder $query, $isGoodCondition)
    {
        if (isset($isGoodCondition)) {
            return $query->where('is_good_condition', $isGoodCondition);
        }
    }
}
