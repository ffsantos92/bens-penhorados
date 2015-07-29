<?php

/*
 * This file is part of Bens Penhorados, an undergraduate capstone project.
 *
 * (c) Fábio Santos <ffsantos92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Models\Items\Attributes;

use App\Models\Items\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the vehicle's model model class.
 *
 * @property int $id
 * @property string $name
 * @property string $regex
 * @property int $make_id
 */
class VehicleModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicle_models';

    /**
     * The primary key column.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * A model belongs to a make.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function make()
    {
        return $this->belongsTo(VehicleMake::class);
    }

    /**
     * Scope a query to only include models of a given make.
     *
     * @param Builder $query
     * @param int     $makeId
     *
     * @return Builder
     */
    public function scopeOfMake(Builder $query, $makeId)
    {
        return $query->where('make_id', $makeId);
    }

    /**
     * Scope a query to only include models assigned at least to one vehicle.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeAssigned(Builder $query)
    {
        $models = Vehicle::distinct()->lists('model_id');

        return $query->whereIn('id', $models)->orderBy('name');
    }
}
