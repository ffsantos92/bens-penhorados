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

use App\Models\Attributes\Property\LandRegistry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the property model class.
 *
 * @author Fábio Santos <ffsantos92@gmail.com>
 *
 * @property int          $id
 * @property bool         $location_on_desc
 * @property int          $typology
 * @property Item         $item
 * @property LandRegistry $landRegistry
 */
class Property extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'properties';

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
     * Get the property's generic data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }

    /**
     * An item must be associated with a land registry type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function landRegistry()
    {
        return $this->hasOne(LandRegistry::class, 'id', 'land_registry_id');
    }

    /**
     * Scope a query to only include active properties.
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
     * Scope a query to only include items of a given land registry type.
     *
     * @param Builder $query
     * @param int     $landRegistryId
     *
     * @return Builder
     */
    public function scopeOfLandRegistry(Builder $query, $landRegistryId)
    {
        if (isset($landRegistryId)) {
            return $query->where('land_registry_id', $landRegistryId);
        }
    }

    /**
     * Scope a query to only include items of a given typology.
     *
     * @param Builder $query
     * @param int     $typology
     *
     * @return Builder
     */
    public function scopeOfTypology(Builder $query, $typology)
    {
        if (isset($typology)) {
            return $query->where('typology', $typology);
        }
    }
}
