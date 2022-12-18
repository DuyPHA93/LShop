<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'start_date', 'end_date', 'created_at', 'updated_at'
    ];

    /**
     * Get the product that owns the featured product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
