<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'active', 'created_at', 'updated_at'
    ];

    /**
     * Get all of the product type's file.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Get the brands for the product type.
     */
    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    /**
     * Get the available brands for the product type.
     */
    public function availableBrands()
    {
        return $this->brands()->where('active', 1)->get();
    }
}
