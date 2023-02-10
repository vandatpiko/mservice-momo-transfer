<?php
namespace VandatPiko\Mservice\Models;

use Illuminate\Database\Eloquent\Model;

class MserviceMomo extends Model
{
    protected $fillable = [];

    /**
     * @var array
    */
    /**
     * function getTable
     */
    public function getTable()
    {
        return config('mservice.table', parent::getTable());
    }

    /**
     * After hidden fields
     */

    protected $hidden = [];

    /**
     * @var array
     */

    protected $appends = [];

    /**
     * @param array $attributes
     */

    protected $casts = [];

    /**
     * static function create
     */
    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }

    /**
     * @param array $attributes
     */
}
