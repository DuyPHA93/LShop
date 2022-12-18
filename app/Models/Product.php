<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'description', 'price', 'product_type_id', 'brand_id', 'quantity', 'active', 'created_at', 'updated_at'
    ];

    /**
     * Get all of the product type's file.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Get the product type that owns the product.
     */
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
